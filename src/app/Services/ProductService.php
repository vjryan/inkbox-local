<?php

namespace App\Services;
use App\Models\Product;

class ProductService{


    public function getProduct($id = null)
    {
        if(empty($id) === true){
            return false;
        }

        return Product::find($id) ?? false;
    }

    public function getProductList()
    {
        return Product::all();
    }

    public function updateInventory(Product $product, $quanity){

        try{
            $product->inventory_quantity += $quanity;
            $product->save();
        }catch(\Exception $e){
            return $e->getMessage();
        }
        
    }
}