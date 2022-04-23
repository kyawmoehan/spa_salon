<?php

namespace App\Exports;

use App\Models\UsageItem;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UsageItemsExport implements FromQuery, WithStrictNullComparison, WithMapping, WithHeadings ,ShouldAutoSize
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
    public function map($usageitem): array
    {
        $this->rowNumber++;

        return [
            // $usageitem->id,
            $this->rowNumber,
            $usageitem->item->name,
            $usageitem->quantity,
            $usageitem->source,
            $usageitem->date,
            $usageitem->remark,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Item',
            'Quantity',
            'Source',
            'Date',
            'Remark',
        ];
    }

    public function query()
    {
        return UsageItem::query()->whereBetween('date', [$this->from, $this->to]);
    }
}
