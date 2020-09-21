<?php

namespace App\Support;

class PrintMapper
{

    const MAX_WIDTH = 10;
    const MAX_HEIGHT = 15;
    
    public $root;
    public $maxArea;
    public $areaUsed;
    public $blocks;
    public $id;

    public function __construct($maxW = self::MAX_WIDTH, $maxH = self::MAX_HEIGHT)
    {
        $this->maxArea  = $maxW * $maxH;
        $this->areaUsed = 0;
        $this->id       = uniqid();
    }
       
    public function fit(&$blocks, $def_w=self::MAX_WIDTH, $def_h=self::MAX_HEIGHT)
    {
        $len = count($blocks);
        
        if (!isset($def_w)) {
            $w = $len > 0 ? $blocks[0]->w : 0;
        }else {
            $w = $def_w;
        }

        if (!isset($def_h)) {
            $h = $len > 0 ? $blocks[0]->h : 0;
        }else {
            $h = $def_h;
        }
        
        $this->root = (object) array(
            'x' => 0,
            'y' => 0,
            'w' => $w,
            'h' => $h,
            'used' => false,
        );
        
        foreach ($blocks as &$block) {
            
            $this->updateUsedArea($block->w, $block->h);
            $node = $this->findNode($this->root, $block->w, $block->h);
            
            if ($node) {
                $block->fit = $this->splitNode($node, $block->w, $block->h);
            } else {
                $block->fit = $this->growNode($block->w, $block->h);
            }
        }

        $this->blocks = $blocks;
    }
    
    public function findNode(&$root, $w, $h)
    {
        if (@$root->used) {
            $node = $this->findNode($root->right, $w, $h);
            if ($node) {
                return $node;
            }
            $node = $this->findNode($root->down, $w, $h);
            if ($node) {
                return $node;
            }
        } else if (($w <= $root->w) && ($h <= $root->h)) {
            return $root;
        } else {
            return null;
        }
    }
    
    public function splitNode(&$node, $w, $h)
    {
        $node->used = true;
        $node->down = (object) array(
            'x' => $node->x,
            'y' => $node->y + $h,
            'w' => $node->w,
            'h' => $node->h - $h,
        );
        $node->right = (object) array(
            'x' => $node->x + $w,
            'y' => $node->y,
            'w' => $node->w - $w,
            'h' => $h,
        );
        return $node;
    }
    
    public function growNode($w, $h)
    {
        $canGrowDown = ($w <= $this->root->w);
        $canGrowRight = ($h <= $this->root->h);
        
        $shouldGrowRight = $canGrowRight && ($this->root->h >= ($this->root->w + $w));
        $shouldGrowDown = $canGrowDown && ($this->root->w >= ($this->root->h + $h));

        if ($shouldGrowRight) {
            return $this->growRight($w, $h);
        }
        else
        if ($shouldGrowDown) {
            return $this->growDown($w, $h);
        }
        else
        if ($canGrowRight) {
            return $this->growRight($w, $h);
        }
        else
        if ($canGrowDown) {
            return $this->growDown($w, $h);
        }
        else {
            // if this happens, sizes werent sorted properly.
            // do that first.
            return null;
        }
    }

    public function growRight($w, $h)
    {
        $this->root = (object) array(
            'used' => true,
            'x' => 0,
            'y' => 0,
            'w' => $this->root->w + $w,
            'h' => $this->root->h,
            'down' => $this->root,
            'right' => (object) array(
                'x' => $this->root->w,
                'y' => 0,
                'w' => $w,
                'h' => $this->root->h,
            )
        );
        $node = $this->findNode($this->root, $w, $h);
        if ($node) {
            return $this->splitNode($node, $w, $h);
        } else {
            return null;
        }
    }

    public function growDown($w, $h)
    {
        $this->root = (object)array(
            'used' => true,
            'x' => 0,
            'y' => 0,
            'w' => $this->root->w,
            'h' => $this->root->h + $h,
            'down' => $this->root,
            'right' => (object) array(
                'x' => 0,
                'y' => $this->root->h,
                'w' => $this->root->w,
                'h' => $h,
            )
        );

        $node = $this->findNode($this->root, $w, $h);
        if ($node) {
            return $this->splitNode($node, $w, $h);
        } else {
            return null;
        }
    }

    public function canFit(array $collection){

        $availableSpace = $this->areaUsed;
        foreach($collection as $item){
            $availableSpace += ($item->w * $item->h);
        }

        if($availableSpace > $this->maxArea){
            return false;
        }
        return true;
    }

    public function updateUsedArea($w, $h){
        $this->areaUsed = $this->areaUsed + ($w * $h);
    }
}