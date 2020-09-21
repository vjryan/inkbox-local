<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintSheetItem extends Model
{
    protected  $primaryKey = 'psi_id';
    protected  $fillable = [
        'ps_id',
        'order_item_id',
        'image_url',
        'size',
        'x_pos',
        'y_pos',
        'width',
        'height',
        'identifier',
    ];


    public function printSheets()
    {
        return $this->belongsTo(PrintSheetItem::class, 'ps_id', 'ps_id');
    }

    public function orderItems()
    {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'order_item_id');
    }
}
