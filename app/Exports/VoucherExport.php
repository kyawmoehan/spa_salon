<?php

namespace App\Exports;

use App\Models\Voucher;
use App\Models\Customer;
use App\Models\User;
// use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VoucherExport implements FromQuery, WithStrictNullComparison, WithMapping, WithHeadings ,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct(String $from, String $to, bool $halfPayment)
    {
        $this->from = $from;
        $this->to = $to;
        $this->half = $halfPayment;
    }

    public function map($voucher): array
    {
        return [
            $voucher->id,
            $voucher->voucher_number,
            $voucher->customer->name,
            $voucher->date,
            $voucher->total,
            $voucher->paid,
            $voucher->discount,
            $voucher->user->name,
            $voucher->payment,
            $voucher->half_payment,
            $voucher->remark,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Voucher Number',
            'Customer',
            'Date',
            'Total',
            'Paid',
            'Discount',
            'Casher',
            'Payment',
            'Half Payment',
            'Remark',
        ];
    }

    public function query()
    {
        if($this->from != null && $this->to != null && $this->half){
            return Voucher::query()->whereBetween('date', [$this->from, $this->to])
            ->where('half_payment', '=', 1);
        }
        else if($this->from != null && $this->to != null){
            return Voucher::query()->whereBetween('date', [$this->from, $this->to]);
        }else if($this->half){
            return Voucher::query()->where('half_payment', '=', 1);
        }
    }
}
