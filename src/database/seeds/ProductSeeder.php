<?php

use Illuminate\Database\Seeder;
use App\Product;
use Faker\Generator as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = new Faker();
        $sizes = ['1x1', '2x2', '3x3', '4x4', '5x2', '2x5'];

        foreach($sizes as $key => $size){
            $product  = new Product([
                'title' => 'Product '.($key+1),
                'type'  => 'tattoo',
                'size'  => $size,
                'price' => rand(10, 20),
                'inventory_quantity' => rand(10, 20),
            ]);
            $product->save();
        }
    }
}
