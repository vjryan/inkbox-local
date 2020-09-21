<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Order;
use App\Services\OrderService;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::get();
        $service =  new OrderService();

        $count = rand(50, 100);
        for($i = 0; $i < 100; $i++){
            
            $data = $this->generateDummyOrder($products);
            $order =  $service->createOrder(
                rand(1, 50),
                $data
            );
            if(empty($order['error']) === false){
                var_dump($order);
            }
            unset($data);
        }

        // process Orders
        // $service->process();
    }

    function generateDummyOrder($products)
    {
        $cart = $this->generateCartItems($products);

        if(count($cart) === 0){
            $this->generateDummyOrder($products);
        }
        
        $data = [];
        foreach($cart as $productId => $quantity){
            $data[] = [
                'productId' => $productId,
                'quantity' => $quantity
            ];
        }

        return $data;
    }

    protected function generateCartItems($products)
    {
        
        $sizeofOrder = rand(3, 150);
        $currentSize = 0;
        $items       = [];

        while($currentSize < $sizeofOrder){
            $selectedProduct    = $products->random();
            $productSize        = explode('x', $selectedProduct->size);
            $width              = $productSize[0];
            $height             = $productSize[1];

            // var_dump($selectedProduct);
            if($currentSize + ($width * $height) > $sizeofOrder){
                break;
            }

            if(empty($items[$selectedProduct->product_id]) === false){
                $items[$selectedProduct->product_id] += 1;
            }else{
                $items[$selectedProduct->product_id] = 1;
            }
               
            $currentSize += ($width * $height);
        }

        if(count($items) === 0){
            $this->generateCartItems($products);
        }

        return $items;
    }
}
