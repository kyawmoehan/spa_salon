<?php

namespace App\Http\Controllers;

use App\Models\VoucherStaff;
use Illuminate\Http\Request;
use Input;
use Carbon;

use App\Exports\ServicesExport;
use Maatwebsite\Excel\Facades\Excel;

use Session;

class VoucherStaffController extends Controller
{
    public function __construct() 
    {
        $this->middleware('role:admin');
    }

    public function index(){
        Session::forget('serviceexport');
        $allVoucherStaff= VoucherStaff::query();
        $searched = false;
        if(request('fromdate') && request('todate') && request('search')){
            $from = request('fromdate');
            $to = request('todate');
            $data = request('search');
            $allVoucherStaff
            ->whereBetween('date', [$from, $to])
            ->wherehas('voucher', function($query) use ($data) {
                $query
                ->where('voucher_number', 'Like', "%{$data}%");          
            })
            ->orWhereHas('service', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");
            })
            ->orWhereHas('staff', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");
            });
            $searched = true;
        }else if(request('fromdate') && request('todate')){
            $from = request('fromdate');
            $to = request('todate');
            Session::put('serviceexport', [$from, $to]);
            $allVoucherStaff->whereBetween('date', [$from, $to])->get();
            $searched = true;
        }else if (request('search')) {
            $data = request('search');
            $allVoucherStaff
            ->wherehas('voucher', function($query) use ($data) {
                $query
                ->where('voucher_number', 'Like', "%{$data}%");          
            })
            ->orWhereHas('service', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");          
            })
            ->orWhereHas('staff', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");
            });
            $searched = true;
        }
       
        $voucherStaffs = $allVoucherStaff->orderByDesc('date')->paginate(15);
        return view('voucher.service_list', compact(['voucherStaffs', 'searched']));
    }

    public function export() 
    {
        $value = Session('serviceexport');
        $from = $value[0];
        $to = $value[1];
        return Excel::download(new ServicesExport($from, $to), 'servicelist.xlsx');
    }

    public function getStaffRecord(Request $request)
    {
        $t = Carbon\Carbon::now();
        $year = $t->year;
        $month = $t->month;
        $from = "{$year}-{$month}-1";
        $to = "{$year}-{$month}-31";
        $staffId = $request->id;
        $staffRecords = VoucherStaff::where('staff_id', $staffId)->whereBetween('date', [$from, $to])->get();
        return response()->json($staffRecords, 200);
    }
}
