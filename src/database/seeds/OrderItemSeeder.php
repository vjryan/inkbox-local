<?php

use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get available products
        $products = Product::get();
        $orders   = Order::get();
        $items    = $this->generateItems($products);
        
        // var_dump($items);


        $orders->each(function($order, $key) use ($items){
            // var_dump($order->toArray());

            foreach($items as $item){
                // Create an Order Item

                $orderItem = new OrderItem([
                    'order_id'   => $order->order_id,
                    'product_id' => $item['product_id'],
                    'quantity'   => 1,                    
                ]);

                $orderItem->save();
                unset($orderItem);
            }
        });


    }

    // Generates a random order between with an area between 1 and 150
    protected function generateItems($products)
    {
        $sizeofOrder = rand(1, 150);
        $currentSize = 0;
        $items       = [];

        // var_dump('Order Max: '.$sizeofOrder);

        while($currentSize < $sizeofOrder){
            $selectedProduct    = $products->random();
            $productSize        = explode('x', $selectedProduct->size);
            $width              = $productSize[0];
            $height             = $productSize[1];

            // var_dump($selectedProduct);
            if($currentSize + ($width * $height) > $sizeofOrder){
                break;
            }

            $items[] = $selectedProduct->toArray();   
            $currentSize += ($width * $height);
        }
        // var_dump('Total Order Size: '.$currentSize);
        // var_dump($items);

        if(count($items) === 0){
            var_dump('trying again');
            $this->generateItems($products);
        }

        return $items;
    }
}
