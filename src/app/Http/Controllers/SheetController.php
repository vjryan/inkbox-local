<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PrintSheet;

class SheetController extends Controller
{
    public function index()
    {
        return response()->json(
            PrintSheet::with('printSheetItems.orderItems.products')->get()
        );
    }
    
}
