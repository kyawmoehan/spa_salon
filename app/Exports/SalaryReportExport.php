<?php

namespace App\Exports;

use App\Models\VoucherStaff;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;


class SalaryReportExport implements FromQuery, WithStrictNullComparison, WithMapping, WithHeadings, ShouldAutoSize, WithEvents
{
    use RegistersEventListeners;
    private static $counter = 0;
    public function __construct(String $fromDate, String $toDate, $staff)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->staff = $staff;
        $this->sum = 0;
    }

    public static function afterSheet(AfterSheet $event)
    {
        $result = self::$counter;
        $event->sheet->appendRows(array(
            array('', '', '', '', 'Total Amount', $result, ''),
        ), $event);
    }

    private $rowNumber = 0;
    public function map($VoucherStaff): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $VoucherStaff->staff->name,
            $VoucherStaff->date,
            $VoucherStaff->service->name,
            $VoucherStaff->staff_pct,
            $VoucherStaff->staff_amount,
            $VoucherStaff->name_checkbox ? 'By Name' : '',

        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Date',
            'Service',
            'Percentage',
            'Amount',
            'By Name',
        ];
    }

    public function query()
    {
        self::$counter = VoucherStaff::where([
            ['staff_id', $this->staff],
        ])->whereBetween('date', [$this->fromDate, $this->toDate])->orderBy('date')->sum('staff_amount');
        return
            VoucherStaff::where([
                ['staff_id', $this->staff],
            ])->whereBetween('date', [$this->fromDate, $this->toDate])->orderBy('date');
    }
}
