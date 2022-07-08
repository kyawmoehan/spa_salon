<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Session;

class DailyController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }


    public function dailyReport()
    {
        Session::put('currentpage', "Daily Report");
        $date = Carbon::today();
        if (request('date')) {
            $date = request('date');
        }

        $allServiceReport = [];
        $serviceReport = [];
        $itemsReport = [];

        $vouchers = Voucher::whereDate('date', '=', $date)->get();

        foreach ($vouchers as $voucher) {
            if ($voucher->voucherStaff->isNotEmpty()) {
                array_push($allServiceReport, ...$voucher->voucherStaff);
            }
        }

        foreach ($allServiceReport as $services) {
            $status = true;
            foreach ($serviceReport as $key => $rService) {
                if ($rService['voucherId'] === $services->voucher->voucher_number && $rService['serviceId'] === $services->service_id) {
                    array_push($serviceReport[$key]['staff'], $services->staff->name);
                    $status = false;
                }
            }
            if ($status) {
                array_push($serviceReport, [
                    'voucherId' => $services->voucher->voucher_number,
                    'serviceId' => $services->service_id,
                    'service' => $services->service->name,
                    'servicePrice' => $services->service->price,
                    'staff' => [$services->staff->name],
                    'percentage' => $services->staff_pct,
                    'staffAmount' => $services->staff_amount,
                ]);
            }
        }

        foreach ($vouchers as $voucher) {
            if ($voucher->voucherItems->isNotEmpty()) {
                array_push(
                    $itemsReport,
                    ...$voucher->voucherItems
                );
            }
        }
        return view('report.dailyreport', compact(['serviceReport', 'itemsReport']));
    }
}
