<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\OrderService;
use App\Support\PrintMapper;


class ProcessOrderController extends Controller
{
    public function index()
    {
        // $blocks[] = (object) ['w'=> 3, 'h'=>3, 'item_id' => 'a', 'order_id' => 1];
        // $blocks[] = (object) ['w'=> 3, 'h'=>3, 'item_id' => 'b', 'order_id' => 1];
        // $blocks[] = (object) ['w'=> 4, 'h'=>4, 'item_id' => 'c', 'order_id' => 1];
        // $blocks[] = (object) ['w'=> 4, 'h'=>4, 'item_id' => 'd', 'order_id' => 1];
        // $blocks[] = (object) ['w'=> 4, 'h'=>4, 'item_id' => 'e', 'order_id' => 1];
        // $blocks[] = (object) ['w'=> 4, 'h'=>4, 'item_id' => 'f', 'order_id' => 1];
        // $blocks[] = (object) ['w'=> 4, 'h'=>4, 'item_id' => 'g', 'order_id' => 1];
        // $blocks[] = (object) ['w'=> 5, 'h'=>2, 'item_id' => 'h', 'order_id' => 1];
        // $blocks[] = (object) ['w'=> 5, 'h'=>2, 'item_id' => 'i', 'order_id' => 1];

        
        // $blocks[] = (object) ['w'=> 5, 'h'=>2, 'item_id' => 'a', 'order_id' => 2];
        // $blocks[] = (object) ['w'=> 5, 'h'=>2, 'item_id' => 'b', 'order_id' => 2];
        // $blocks[] = (object) ['w'=> 5, 'h'=>2, 'item_id' => 'c', 'order_id' => 2];

        // $packer = new PrintMapper();

        // $packer->fit($blocks);

        // return response()->json([
        //     'root' =>$packer->root,
        //     'blocks' =>$blocks,
        //     'used' => $packer->areaUsed
        // ]);
    }


    public function processPending()
    {
        $orderService = new OrderService();
        $result = $orderService->process();

        return response()->json($result, 200);
    }
}
