<?php

class Sheet{

    const WIDTH  = 10;
    const HEIGHT = 15;
    
    private $width;
    private $height;
    private $area;
    private $remainingArea;
    private $itemsContained = [];
    
    public function __constructor($width = self::WIDTH, $height = self::HEIGHT)
    {

        $this->width         = $width;
        $this->height        = $height;

        $this->area          = ($this->width * $this->height);
        $this->remainingArea = $this->area;
    }

    public function add($product)
    {
        if($product->getArea() <= $this->remainingArea){
            $this->itemsContained[] = $product;
            $this->remainingArea -= $product->getArea();
            return true;
        }
        return false;
    }

    public function fillSheetWithOrder($order)
    {
        if($this->canFitOrder($order) === false){
            return false;
        }

        // get items from order 

        // sort items from order

        // add items from order.
    }

    private function canFitOrder($order)
    {
        if($order->totalArea <= $this->remainingArea){
            return true;
        }
        return false;
    }
}