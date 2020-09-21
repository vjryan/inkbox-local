<?php

namespace App\Services;

use App\Support\PrintMapper;
use App\Models\PrintSheet;
use App\Models\PrintSheetItem;

class PrintService
{

    protected $sheets;
    protected $currentSheet;

    public function  __construct()
    {
        $this->sheets = [];    
        $this->currentSheet = null;
    }

    /**
     * Checks to see if order can fit on a single sheet
     * @param array         $items (items inside should be object)
     * @param PrintMapper   $sheet
     * 
     * @return boolean
     */
    public function canOrderFit(array $items, PrintMapper $sheet = null)
    {
        if(empty($sheet) === true){
            $sheet = new PrintMapper();
        }
        return $sheet->canFit($items);
    }

    /**
     * Takes an array of orderItems for printing and maps them to a sheet.
     * 
     * @param array $orderItems 
     */
    public function map(array $orderItems)
    {
        $sheet = new PrintMapper();
        foreach($orderItems as $orderId => $items){
            $spaceAvailable = $sheet->canFit($items);
            if($spaceAvailable === false){
                // save this sheet
                $this->sheets[$sheet->id] = $sheet;
                // create new sheet for next order.
                $sheet = new PrintMapper();
            }
            $sheet->fit($items);
        }

        if(empty($this->sheets[$sheet->id]) === true){
            $this->sheets[$sheet->id] = $sheet;
        }
        
        return $this->sheets;
    }

    public function savePrintSheet(PrintMapper $filledSheet)
    {
       // Create a Print Sheet
       $printSheet =  new PrintSheet([
           'sheet_url' => uniqid()
       ]);
       $printSheet->save();
        
       // map the print sheet to printed items.
       foreach($filledSheet->blocks as $item){
        try{
            $printSheetItem = new PrintSheetItem([
                'ps_id'         => $printSheet->ps_id,
                'order_item_id' => $item->order_item_id,
                'image_url'     => $item->design_url,
                'size'          => "{$item->w} x {$item->h}",
                'x_pos'         => $item->fit->x,
                'y_pos'         => $item->fit->y,
                'width'         => $item->w,
                'height'        => $item->h,
                'identifier'    => "{$item->order_id}:{$item->product_id}",
           ]);
           $printSheetItem->save();
        }catch(\Exception $e){
            var_dump($e->getMessage());
            return $item;
        }
           
       }
       return true;
    }
}