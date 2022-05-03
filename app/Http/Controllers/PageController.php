<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;

use App\Models\Customer;
use App\Models\ItemVoucher;
use App\Models\VoucherStaff;
use App\Models\ItemList;
use App\Models\Voucher;
use App\Models\GeneralCost;
use App\Models\UsageItem;
use App\Models\Salary;
use Session;

class PageController extends Controller
{
    public function __construct() 
    {   
        $this->middleware('auth')->only('dashboard');
        $this->middleware('role:admin')->only('popular', 'profit');
    }

    public function topItemsList($from,$to)
    {
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

        return array_slice($countItems, 0, 10);
    }

    public function topServicesList($from, $to)
    {
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
        return array_slice($countServices, 0, 10);
    }

    public function existYears()
    {
        $allVouchers = Voucher::all();
        $years = [];
        foreach($allVouchers as $voucher){
            $year = explode('-', $voucher->date)[0];
            if(!in_array($year, $years)){
                array_push($years, $year);
            }
        }
        return $years;
    }
    
    public function dashboard()
    {
        Session::put('currentpage', "Dashboard");
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

        $countItems = $this->topItemsList($from, $to);
       
        $countServices = $this->topServicesList($from, $to);
       

        return view('home/home', compact(['new_customers','todaySales', 'todayServices', 'itemsStock','countItems', 'countServices']));
    }

    public function popular()
    {
        Session::put('currentpage', "Popular Item & Services");
        $t = Carbon\Carbon::now();
        $year = $t->year;
        $month = $t->month;
        $from = "{$year}-{$month}-1";
        $to = "{$year}-{$month}-31";

        $countItems = $this->topItemsList($from, $to);

        $years = $this->existYears();
       
        $countServices = $this->topServicesList($from, $to);
        return view('report.popular', compact(['countItems', 'countServices', 'years']));
    }

    public function calculateProft($months, $year)
    {
        $yearProfits = [];
        foreach($months as $key=>$monthName){
            $month = $key+1;
            $from = "{$year}-{$month}-1";
            $to = "{$year}-{$month}-31";
            $voucherCost = Voucher::whereBetween('date', [$from, $to])->sum('paid');
            $itemCost = ItemVoucher::whereBetween('date', [$from, $to])->sum('total');
            $generalCost = GeneralCost::whereBetween('date', [$from, $to])->sum('cost');
            $usageCost = UsageItem::whereBetween('date', [$from, $to])->sum('total');
            $salaryCost = Salary::whereBetween('date', [$from, $to])->sum('total_amount');
            $profit = [
                'voucherCost'=> $voucherCost,
                'itemCost' => $itemCost,
                'generalCost' => $generalCost,
                'usageCost' => $usageCost,
                'salaryCost' => $salaryCost,
                'profit' => $voucherCost-$itemCost-$generalCost-$usageCost-$salaryCost,
            ];
            array_push($yearProfits, $profit);
        }
        return $yearProfits;
    }

    public function profit()
    {
        Session::put('currentpage', "Monthly Profit");
        $t = Carbon\Carbon::now();
        $year = $t->year;
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $yearProfits = $this->calculateProft($months, $year);

        $years = $this->existYears();
        return view('report.profit', compact(['yearProfits', 'months', 'years']));
    }

    public function getTopItems(Request $request)
    {
        $itemSeletMonth = $request->itemMonth;
        $itemSeletYear = $request->itemYear;
        $t = Carbon\Carbon::now();
        $year = $t->year;
        if($itemSeletYear != null){
            $year = $itemSeletYear;
        }
        $month = $itemSeletMonth;
        $from = "{$year}-{$month}-1";
        $to = "{$year}-{$month}-31";

        $countItems = $this->topItemsList($from, $to);
        return response()->json($countItems, 200);
    }

    public function getTopServices(Request $request)
    {
        $serviceSeletMonth = $request->serviceMonth;
        $serviceSeletYear = $request->serviceYear;
        $t = Carbon\Carbon::now();
        $year = $t->year;
        if($serviceSeletYear != null){
            $year = $serviceSeletYear;
        }
        $month = $serviceSeletMonth;
        $from = "{$year}-{$month}-1";
        $to = "{$year}-{$month}-31";
        
       $countServices = $this->topServicesList($from, $to);

        return response()->json($countServices, 200);
    }

    public function getProfit(Request $request)
    {
        $profitYear = $request->profitYear;
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $yearProfits = $this->calculateProft($months, $profitYear);

        $data = [
            'yearProfits' => $yearProfits,
            'months' => $months,
        ];

        return response()->json($data, 200);
    }
}
