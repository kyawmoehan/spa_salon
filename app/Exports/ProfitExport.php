<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Carbon;

use App\Models\ItemVoucher;
use App\Models\Voucher;
use App\Models\GeneralCost;
use App\Models\UsageItem;
use App\Models\Salary;

class ProfitExport implements FromView, WithStrictNullComparison, ShouldAutoSize
{
    public function __construct(String $year)
    {
        $this->year = $year;
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

    public function view(): View
    {
        $t = Carbon\Carbon::now();
        $year = $t->year;
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $yearProfits = $this->calculateProft($months, $this->year);

        return view('report.profit_excel', [
            'yearProfits' => $yearProfits,
            'months' => $months,
        ]);
    }
}
