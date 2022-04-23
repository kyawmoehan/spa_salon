<?php

namespace App\Exports;

use App\Models\ItemVoucher;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalesExport implements FromQuery, WithStrictNullComparison, WithMapping, WithHeadings ,ShouldAutoSize
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
    public function map($itemVoucher): array
    {
        $this->rowNumber++;

        return [
            // $itemVoucher->id,
            $this->rowNumber,
            $itemVoucher->voucher->voucher_number,
            $itemVoucher->voucher->customer->name,
            $itemVoucher->item->name,
            $itemVoucher->quantity,
            $itemVoucher->price,
            $itemVoucher->quantity * $itemVoucher->price,
            $itemVoucher->source,
            $itemVoucher->date,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Voucher Number',
            'Customer',
            'Item',
            'Quantity',
            'Price',
            'Total',
            'Source',
            'date',
        ];
    }

    public function query()
    {
        return ItemVoucher::query()->whereBetween('date', [$this->from, $this->to]);
    }
}
