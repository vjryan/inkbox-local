<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected  $primaryKey = 'order_item_id';


    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
