<?php

namespace App\Http\Controllers;

use App\Models\VoucherStaff;
use Illuminate\Http\Request;
use Input;
use Carbon;

class VoucherStaffController extends Controller
{
    public function getStaffRecord(Request $request)
    {
        $t = Carbon\Carbon::now();
        $year = $t->year;
        $month = $t->month;
        $from = "{$year}-{$month}-1";
        $to = "{$year}-{$month}-31";
        $staffId = $request->id;
        $staffRecords = VoucherStaff::where('staff_id', $staffId)->whereBetween('date', [$from, $to])->get();
        return response()->json($staffRecords, 200);
    }
}
