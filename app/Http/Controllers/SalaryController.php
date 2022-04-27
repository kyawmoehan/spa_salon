<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Staff;
use Illuminate\Http\Request;

use App\Exports\SalariesExport;
use Maatwebsite\Excel\Facades\Excel;

use Session;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() 
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        Session::forget('salaryexport');
        $this->authorize('viewAny', Salary::class);
       
        $allSalaries = Salary::query();
        $searched = false;
        if(request('fromdate') && request('todate') && request('search')){
            $from = request('fromdate');
            $to = request('todate');
            $data = request('search');
            $allSalaries->whereBetween('date', [$from, $to])->whereHas('staff', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");          
            });
            $searched = true;
        }else if(request('fromdate') && request('todate')){
            $from = request('fromdate');
            $to = request('todate');
            Session::put('salaryexport', [$from, $to]);
            $allSalaries->whereBetween('date', [$from, $to])->get();
            $searched = true;
        }else if (request('search')) {
            $data = request('search');
            $allSalaries->whereHas('staff', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");          
            });
            $searched = true;
        }
        $salaries = $allSalaries->orderByDesc('date')->paginate(10);
        return view('salary.salary_list', compact(['salaries', 'searched']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staffs = Staff::all();
        return view('salary.salary_create', compact(['staffs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $request->validate([
            'staff_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        $this->authorize('create', Salary::class);
        
        // store data 
        $salary = new Salary();
        $salary->staff_id = request('staff_id');
        $salary->amount = request('amount');
        $salary->service_amount = request('service_amount');
        $salary->total_amount = request('total_amount');
        $salary->date = request('date');
        $salary->remark = request('remark');
 
        $salary->save();
         
        return redirect()->route('salary.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $salary)
    {
        $staffs = Staff::all();
        return view('salary.salary_edit', compact(['salary', 'staffs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salary $salary)
    {
        //Validation
        $request->validate([
            'staff_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
        ]);

        $this->authorize('update', $salary);
        
        // store data 
        $salary->staff_id = request('staff_id');
        $salary->amount = request('amount');
        $salary->service_amount = request('service_amount');
        $salary->total_amount = request('total_amount');
        $salary->date = request('date');
        $salary->remark = request('remark');
 
        $salary->save();
         
        return redirect()->route('salary.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {
        $this->authorize('delete', $salary);
        $salary->delete();
        return redirect()->route('salary.index');
    }

    public function export() 
    {
        $value = Session('salaryexport');
        $from = $value[0];
        $to = $value[1];
        return Excel::download(new SalariesExport($from, $to), 'generalcost.xlsx');
    }
}
