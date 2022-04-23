<?php

namespace App\Exports;

use App\Models\Salary;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalariesExport implements FromQuery, WithStrictNullComparison, WithMapping, WithHeadings ,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(String $from, String $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function map($salary): array
    {
        return [
            $salary->id,
            $salary->staff->name,
            $salary->amount,
            $salary->service_amount,
            $salary->total_amount,
            $salary->remark,
            $salary->date,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Staff',
            'Amount',
            'Service Amount',
            'Total Amount',
            'Remark',
            'Date',
        ];
    }

    public function query()
    {
        return Salary::query()->whereBetween('date', [$this->from, $this->to]);
    }
}
