<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintSheet extends Model
{
    protected  $primaryKey = 'ps_id';   
    protected $fillable = [
        'sheet_url'
    ];


    public function printSheetItems()
    {
        return $this->hasMany(PrintSheetItem::class, 'ps_id', 'ps_id');
    }
}
