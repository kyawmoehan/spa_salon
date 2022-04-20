<?php

namespace App\Http\Controllers;

use App\Models\ItemList;
use Illuminate\Http\Request;

class ItemListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function addItem($item_id, $source, $quantity){
        $item = ItemList::where('item_id', '=', $item_id)->exists();
        if($item == null){
            $itemList = new ItemList();
            $itemList->item_id = $item_id;
            if($source == 'purchase'){
                $itemList->purchase = $quantity;
                $itemList->counter = 0;
            }else if($source == 'counter'){
                $itemList->purchase = 0;
                $itemList->counter = $quantity;
            }
            $itemList->save();
        }else {
            $itemList =  ItemList::where('item_id', $item_id)->first();
          
            $purchaseQuntity = $itemList->purchase;
            $counterQuntity = $itemList->counter;
            // $itemList->item_id = $item_id;
            if($source == 'purchase'){
                $itemList->purchase = $purchaseQuntity+ $quantity;
                $itemList->counter = $counterQuntity;
            }else if($source == 'counter'){
                $itemList->purchase = $purchaseQuntity;
                $itemList->counter = $counterQuntity + $quantity;
            }
            $itemList->save();
        }
    }

    public function removeItem($item_id, $source, $quantity){
        $item = ItemList::where('item_id', '=', $item_id)->exists();
        if($item) {
            $itemList =  ItemList::where('item_id', $item_id)->first();
          
            $purchaseQuntity = $itemList->purchase;
            $counterQuntity = $itemList->counter;
            
            if($source == 'purchase'){
                $itemList->purchase = $purchaseQuntity - $quantity;
                $itemList->counter = $counterQuntity;
            }else if($source == 'counter'){
                $itemList->purchase = $purchaseQuntity;
                $itemList->counter = $counterQuntity - $quantity;
            }
            $itemList->save();
        }
    }

}