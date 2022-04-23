<?php

namespace App\Exports;

use App\Models\GeneralCost;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GeneralCostsExport implements FromQuery, WithStrictNullComparison, WithMapping, WithHeadings ,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(String $from, String $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function map($generalcost): array
    {
        return [
            $generalcost->id,
            $generalcost->cost_type,
            $generalcost->reason,
            $generalcost->cost,
            $generalcost->date,
            $generalcost->remark,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Cost Type',
            'Reason',
            'Cost',
            'Date',
            'Remark',
        ];
    }

    public function query()
    {
        return GeneralCost::query()->whereBetween('date', [$this->from, $this->to]);
    }
}
