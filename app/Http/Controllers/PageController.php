<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;

use App\Models\Customer;
use App\Models\ItemVoucher;
use App\Models\VoucherStaff;
use App\Models\ItemList;

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

        $getTodaySales = ItemVoucher::whereDate('created_at', '=', Carbon\Carbon::today())
        ->get();
        $todaySales = 0;
        foreach($getTodaySales as $getTodaySale){
            $todaySales += $getTodaySale->quantity;
        }


        $gettodayServices = VoucherStaff::whereDate('created_at', '=', Carbon\Carbon::today())
        ->get();
        $todayServices = 0;
        $servicesId = [];
        foreach($gettodayServices as $service){
            if(array_key_exists($service->voucher_id, $servicesId) &&
            !in_array($service->service->name, $servicesId[$service->voucher_id]) ){
                array_push($servicesId[$service->voucher_id], $service->service->name );
            }else if(!array_key_exists($service->voucher_id, $servicesId)){
                $servicesId[$service->voucher_id] = [$service->service->name];   
            }
        }
        foreach($servicesId as $services){
            foreach($services as $service){
                $todayServices++;
            }
        }

        $getItemLists = ItemList::all();
        $itemsStock = 0;
        foreach($getItemLists as $getItemList){
            $itemsStock += $getItemList->purchase;
            $itemsStock += $getItemList->counter;
        }

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

        $allServices =  VoucherStaff::whereBetween('date', [$from, $to])->get();
        $countServices = [];
        $voucherIds = [];
        foreach($allServices as $service){
            if(array_key_exists($service->voucher_id, $voucherIds) &&
            !in_array($service->service->name, $voucherIds[$service->voucher_id]) ){
                array_push($voucherIds[$service->voucher_id], $service->service->name );
            }else if(!array_key_exists($service->voucher_id, $voucherIds)){
                $voucherIds[$service->voucher_id] = [$service->service->name];   
            }
        }

        foreach($voucherIds as $services){
                foreach($services as $service){
                    if(array_key_exists($service, $countServices)){
                        $countServices[$service] += 1;
                    }else{
                        $countServices[$service] = 1;
                    }   
                }
        }
        arsort($countServices);

        return view('home/home', compact(['new_customers','todaySales', 'todayServices', 'itemsStock','countItems', 'countServices']));
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

    public function getTopServices(Request $request)
    {
        $serviceSeletMonth = $request->serviceMonth;
        $t = Carbon\Carbon::now();
        $year = $t->year;
        $month = $serviceSeletMonth;
        $from = "{$year}-{$month}-1";
        $to = "{$year}-{$month}-31";
        
        $allServices =  VoucherStaff::whereBetween('date', [$from, $to])->get();
        $countServices = [];
        $voucherIds = [];
        foreach($allServices as $service){
            if(array_key_exists($service->voucher_id, $voucherIds) &&
            !in_array($service->service->name, $voucherIds[$service->voucher_id]) ){
                array_push($voucherIds[$service->voucher_id], $service->service->name );
            }else if(!array_key_exists($service->voucher_id, $voucherIds)){
                $voucherIds[$service->voucher_id] = [$service->service->name];   
            }
        }

        foreach($voucherIds as $services){
                foreach($services as $service){
                    if(array_key_exists($service, $countServices)){
                        $countServices[$service] += 1;
                    }else{
                        $countServices[$service] = 1;
                    }   
                }
        }
       
        arsort($countServices);

        return response()->json($countServices, 200);
    }
}
