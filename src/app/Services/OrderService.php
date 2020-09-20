<?php

namespace App\Services;

use App\Services\ProductService;
use App\Services\PrintService;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;

class OrderService{

    protected $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }
    
    public function getOrder($id)
    {
        return Order::with('orderItems.products')->find($id) ?? false;
    }

    public function getAllOrders()
    {
        return Order::with('orderItems.products')->get() ?? false;
    }

    public function createOrder($customerId, $cart)
    {
        // get details of items and validates cart
        list($error, $orderTotal, $orderItems) = $this->parseOrder($cart);
        
        if($error !== false){
            return [
                'error' => $error
            ];
        }
       
        // create order object
        $order = new Order([
            'order_number' => $this->generateOrderId(),
            'customer_id'  => (int) $customerId, // would normally validate customer.
            'total_price'  => (float) $orderTotal,
            'fulfillment_status' => 'Order Created',
            'order_status'       => 'Pending',
        ]);
        
        try{
            $result = $order->save();
        }catch(Exception $e){
            return $e->getMessage();
        }

        // update inventory of products
        $this->updateInventory($orderItems);

        // add items for printing.
        $this->addOrderedItems($orderItems, $order->order_id);

        return [
            'order' => $order
        ];
    }

    /**
     * Checks to see if an order being created can fit onto a single sheet or not.
     * will return false if it cant, otherwise it will return the individual items 
     * required for printing
     * 
     * @param array $products
     * 
     * @return mixed
     */
    protected function canOrderItemsFit(array $products)
    {
        
        $orderItems = [];
        // Going to flatten for later usage;
        foreach($products as $product){
            for($i = 0; $i < $product['quantity']; $i++){
                $dimensions = explode('x', $product['product']['size']);
                $orderItems[] = (object) [
                    'product'       => $product['product'],
                    'quantity'      => 1,
                    'w'             => $dimensions[0],
                    'h'             => $dimensions[1],
                ];
            }
        }

        $canFit = (new PrintService)->canOrderFit($orderItems);
        if($canFit === false){
            return false;
        }

        return $orderItems;
    }

    protected function addOrderedItems(array $orderItems, int $orderId)
    {
        foreach($orderItems as $orderItem){
            $orderItem = new OrderItem([
                'order_id'      => $orderId,
                'product_id'    => $orderItem->product->product_id,
                'quantity'      => $orderItem->quantity
            ]);
            try{
                $result = $orderItem->save();
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
    }

    protected function parseOrder(array $cart)
    {
        $productDetails = [];
        $orderTotal     = 0;
        $orderItems     = false;

        foreach($cart as $item){
            $product = $this->productService->getProduct( (int) $item['productId']);

            if($product === false){
                return [                    
                    "One of the items in your cart (product: {$item['productId']}) is not available at this time.",
                    $orderTotal, 
                    $orderItems
                ];
            }

            if($product->inventory_quantity === 0){
                return [
                    "{$product->title} is no longer in stock.",
                    $orderTotal, 
                    $orderItems
                ];
            }

            if($product->inventory_quantity < $item['quantity']){
                return [
                    "Not enough inventory of {$product->title} to fill order, pick lower quantity.",
                    $orderTotal, 
                    $orderItems
                ];
            }

            $productDetails[] = [
                'quantity' => $item['quantity'],
                'product' => $product
            ];
            
            $orderTotal += $product->price * $item['quantity'];
        }

        // Check to see if the order can fit into a single sheet
        $orderItems = $this->canOrderItemsFit($productDetails);

        // too many items to fit on a single sheet.
        if($orderItems === false){
            return [
                "Too many items in cart, unable to process order.",
                $orderTotal, 
                $orderItems
            ];
        }

        return [
            false, 
            $orderTotal,
            $orderItems
        ];
    }


    protected function updateInventory(array $orderItems)
    {
        foreach($orderItems as $item){
            $this->productService->updateInventory($item->product, ($item->quantity * -1) );
        }
    }

    /**
     * Generates a unique order number for tracking purposes 
     * 
     * @return integer
     */
    protected function generateOrderId()
    {
        return time(); // in reality we'd wanna use uniqid() or something like that.
    }
}