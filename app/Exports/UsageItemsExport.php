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

    public function map($usageitem): array
    {
        return [
            $usageitem->id,
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
