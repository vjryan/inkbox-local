<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Order;
// use Faker\Generator as Faker;
// use Faker\Factory   as FakerFactory;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $products         = Product::get();
        // $selectedProduct  = $products->random();
        // var_dump($product);
        $order = new Order([
            'order_number' => time(),
            'customer_id'  => rand(1, 100),
            'order_status' => 'pending',
            'customer_order_count' => 1
        ]);

        $order->save();
    }
}
