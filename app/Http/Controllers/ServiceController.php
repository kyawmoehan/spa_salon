<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Session;

class ServiceController extends Controller
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
        $this->authorize('viewAny', Service::class);
        Session::put('currentpage', "Service List");
        $all_service = Service::query();
        $searched = false;
        if (request('search')) {
            $all_service
            ->where('name', 'Like', '%' . request('search') . '%')            
            ->get();
            $searched = true;
        }
        $services = $all_service->orderBy('id')->paginate(15);
        return view('service.service_list', compact(['services', 'searched']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('currentpage', "Service Create");
        return view('service.service_create');
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
            'name' => 'required',
            'price' => 'required',
            'normal_pct' => 'required',
        ]);

        $this->authorize('create', Service::class);

        // store data 
        $service = new Service();
        $service->name = request('name');
        $service->price = request('price');
        $service->normal_pct = request('normal_pct');
        $service->name_pct = request('name_pct');
        $service->remark = request('remark');
        $service->save();
        
        return redirect()->route('service.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        Session::put('currentpage', "Service Update");
        return view('service.service_edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //Validation
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'normal_pct'=> 'required',
        ]);

        $this->authorize('update', $service);
        
        // store data 
        $service->name = request('name');
        $service->price = request('price');
        $service->normal_pct = request('normal_pct');
        $service->name_pct = request('name_pct');
        $service->remark = request('remark');
        $service->save();
        
        return redirect()->route('service.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);
        $service->delete();
        return redirect()->route('service.index');
    }

    public function getServices(Request $request)
    {
        $searched = $request->searched;
        $allServices = Service::where('name', 'Like', '%' . $searched . '%')->get();
        return response()->json($allServices, 200);
    }
}
