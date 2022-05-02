<?php

namespace App\Exports;

use App\Models\VoucherStaff;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ServicesExport implements FromQuery, WithStrictNullComparison, WithMapping, WithHeadings ,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(String $from, String $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    private $rowNumber = 0;
    public function map($serviceVoucher): array
    {
        $this->rowNumber++;
        return [
            // $serviceVoucher->id,
            $this->rowNumber,
            $serviceVoucher->voucher->voucher_number,
            $serviceVoucher->voucher->customer->name,
            $serviceVoucher->service->name,
            $serviceVoucher->service->price,
            $serviceVoucher->staff->name,
            $serviceVoucher->staff_pct,
            $serviceVoucher->staff_amount,
            $serviceVoucher->date,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Voucher Number',
            'Customer',
            'Service',
            'Service Price',
            'Staff',
            'Percentage',
            'Amount',
            'date',
        ];
    }

    public function query()
    {
        return VoucherStaff::query()->whereBetween('date', [$this->from, $this->to]);
    }
}
