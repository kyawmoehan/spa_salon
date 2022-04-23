<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;

use App\Models\Customer;
use App\Models\ItemVoucher;

class PageController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
        // $this->middleware('role:user');
    }

    
    public function dashboard(){
        $new_customers = Customer::whereDate('created_at', '=', Carbon\Carbon::today())
                            ->count();

        $todaySales = ItemVoucher::whereDate('created_at', '=', Carbon\Carbon::today())
        ->count();

        $t = Carbon\Carbon::now();
        $year = $t->year;
        $month = $t->month;
        $from = "{$year}-{$month}-1";
        $to = "{$year}-{$month}-31";
        $allSaleItems =  ItemVoucher::whereBetween('date', [$from, $to])->get();
        $countItems = [];
        foreach($allSaleItems as $item){
            if(array_key_exists($item->item->name, $countItems)){
                $countItems[$item->item->name] += $item->quantity;
            }else{
                $countItems[$item->item->name] = $item->quantity;
            }
        }
        arsort($countItems);

        return view('home/home', compact(['new_customers','todaySales', 'countItems', 'month']));
    }

    public function getTopItems(Request $request)
    {
        $itemSeletMonth = $request->itemMonth;
        $t = Carbon\Carbon::now();
        $year = $t->year;
        $month = $itemSeletMonth;
        $from = "{$year}-{$month}-1";
        $to = "{$year}-{$month}-31";
        $allSaleItems =  ItemVoucher::whereBetween('date', [$from, $to])->get();
        $countItems = [];
        foreach($allSaleItems as $item){
            if(array_key_exists($item->item->name, $countItems)){
                $countItems[$item->item->name] += $item->quantity;
            }else{
                $countItems[$item->item->name] = $item->quantity;
            }
        }
        arsort($countItems);
        return response()->json($countItems, 200);
    }
}
