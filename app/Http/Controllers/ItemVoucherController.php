<?php

namespace App\Http\Controllers;

use App\Models\ItemVoucher;
use Illuminate\Http\Request;

use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;

use Session;

class ItemVoucherController extends Controller
{
    //
    public function __construct() 
    {
        $this->middleware('role:admin');
    }

    public function index(){
        Session::forget('saleexport');
        $allItemVoucher= ItemVoucher::query();
        $searched = false;
        if(request('fromdate') && request('todate') && request('search')){
            $from = request('fromdate');
            $to = request('todate');
            $data = request('search');
            $allItemVoucher->whereBetween('date', [$from, $to])->whereHas('item', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");
            });
            $searched = true;
        }else if(request('fromdate') && request('todate')){
            $from = request('fromdate');
            $to = request('todate');
            Session::put('saleexport', [$from, $to]);
            $allItemVoucher->whereBetween('date', [$from, $to])->get();
            $searched = true;
        }else if (request('search')) {
            $data = request('search');
            $allItemVoucher
            ->wherehas('voucher', function($query) use ($data) {
                $query
                ->where('voucher_number', 'Like', "%{$data}%");          
            })
            ->orWhereHas('item', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");          
            });
            $searched = true;
        }
       
        $itemVouchers = $allItemVoucher->orderByDesc('date')->paginate(10);
        return view('voucher.sale_list', compact(['itemVouchers', 'searched']));
    }

    public function export() 
    {
        $value = Session('saleexport');
        $from = $value[0];
        $to = $value[1];
        return Excel::download(new SalesExport($from, $to), 'generalcost.xlsx');
    }
}
