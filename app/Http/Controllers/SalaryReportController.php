<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\VoucherStaff;
use Illuminate\Http\Request;
use Session;

use App\Exports\SalaryReportExport;
use Maatwebsite\Excel\Facades\Excel;

class SalaryReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function salaryReport()
    {
        Session::forget('profitexport');
        Session::put('currentpage', "Salary Report");
        $staffs = Staff::where('status', 1)->get();

        $fromDate = request('fromdate');
        $toDate = request('todate');
        $staff = request('staff');
        Session::put('profitexport', [$fromDate, $toDate, $staff]);
        $data = null;
        if ($fromDate && $toDate && $staff) {
            $data = VoucherStaff::where([
                ['staff_id', $staff],
            ])->whereBetween('date', [$fromDate, $toDate])->orderBy('date')
                ->get();
        }
        return view('salary.salary_report', compact(['staffs', 'data',]));
    }

    public function export()
    {
        $data = Session('profitexport');
        return Excel::download(new SalaryReportExport($data[0], $data[1], $data[2]), 'salaryreport.xlsx');
    }
}
