<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected  $primaryKey = 'order_id';

    protected $fillable = [
        'order_id',
        'order_number',
        'customer_id',
        'total_price',
        'fulfillment_status',
        'order_status'
    ];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

}
