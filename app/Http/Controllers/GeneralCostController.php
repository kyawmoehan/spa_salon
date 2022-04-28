<?php

namespace App\Http\Controllers;

use App\Models\GeneralCost;
use Illuminate\Http\Request;
use Carbon;

use App\Exports\GeneralCostsExport;
use Maatwebsite\Excel\Facades\Excel;

use Session;

class GeneralCostController extends Controller
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
        Session::forget('generalcostexport');
        $this->authorize('viewAny', GeneralCost::class);
        $allGeneralCost = GeneralCost::query();
        $searched = false;
        $totalCost = 0;
        if(request('fromdate')){
            $from = request('fromdate');
            $to = request('todate');
            Session::put('generalcostexport', [$from, $to]);
            $allGeneralCost->whereBetween('date', [$from, $to])->get();
            $totalCost = $allGeneralCost->whereBetween('date', [$from, $to])->sum('cost');
            $searched = true;
        }
       
        $generalCosts = $allGeneralCost->orderBy('id')->paginate(15);
        return view('generalcost.generalcost_list', compact(['generalCosts','searched', 'totalCost']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('generalcost.generalcost_create');
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
            'cost_type' => 'required',
            'reason' => 'required',
            'cost' => 'required',
            'date' => 'required',
        ]);

        // $date = Carbon\Carbon::parse($request->date);
        $this->authorize('create', GeneralCost::class);

        // store data 
        $generalCost = new GeneralCost();
        $generalCost->cost_type = request('cost_type');
        $generalCost->reason = request('reason');
        $generalCost->cost = request('cost');
        $generalCost->date = Carbon\Carbon::parse($request->date);
        $generalCost->remark = request('remark');
 
        $generalCost->save();
         
        return redirect()->route('generalcost.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GeneralCost  $generalCost
     * @return \Illuminate\Http\Response
     */
    public function show(GeneralCost $generalCost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GeneralCost  $generalCost
     * @return \Illuminate\Http\Response
     */
    public function edit(GeneralCost $generalcost)
    {
        return view('generalcost.generalcost_edit', compact('generalcost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GeneralCost  $generalCost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeneralCost $generalcost)
    {
        //Validation
        $request->validate([
            'cost_type' => 'required',
            'reason' => 'required',
            'cost' => 'required',
            'date' => 'required',
        ]);

        $this->authorize('update', $generalcost);

        // store data 
        $generalcost->cost_type = request('cost_type');
        $generalcost->reason = request('reason');
        $generalcost->cost = request('cost');
        $generalcost->date = Carbon\Carbon::parse($request->date);
        $generalcost->remark = request('remark');
 
        $generalcost->save();
         
        return redirect()->route('generalcost.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GeneralCost  $generalCost
     * @return \Illuminate\Http\Response
     */
    public function destroy(GeneralCost $generalcost)
    {
        $this->authorize('delete', $generalcost);
        $generalcost->delete();
        return redirect()->route('generalcost.index');
    }

    public function export() 
    {
        $value = Session('generalcostexport');
        $from = $value[0];
        $to = $value[1];
        return Excel::download(new GeneralCostsExport($from, $to), 'generalcost.xlsx');
    }
}
