<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use File;

class StaffController extends Controller
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

    public function index(Request $request)
    {
        $AllStaff = Staff::query();
        if (request('search')) {
            $AllStaff
            ->where('name', 'Like', '%' . request('search') . '%')
            ->orWhere('email', 'Like', '%' . request('search') . '%')
            ->orWhere('phone', 'Like', '%' . request('search') . '%')
            ->orWhere('nrc', 'Like', '%' . request('search') . '%')
            ->orWhere('address', 'Like', '%' . request('search') . '%')
            ->orWhere('position', 'Like', '%' . request('search') . '%')
            ->get();
        }
        $all_staff = $AllStaff->orderBy('id')->paginate(10);
        return view('staff.staff_list', compact('all_staff'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    public function create()
    {
        return view('staff.staff_create');
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
            'name' => 'required|min:4',
            'nrc' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'position' => 'required',
        ]);

        $this->authorize('create', Staff::class);
        //fileupload
        if($request->hasfile('image'))
        {
            $photo = $request->file('image');
            $name = time().'.'. $photo->getClientOriginalExtension();
            $photo->move(public_path().'/images/staff/',$name);
            $photo = '/images/staff/'. $name;
        }
        
        // store data 
        $staff = new Staff();
        $staff->name = request('name');
        $staff->nrc = request('nrc');
        $staff->image = $photo;
        $staff->address = request('address');
        $staff->phone = request('phone');
        $staff->email = request('email');
        $staff->position = request('position');
        $staff->remark = request('remark');

        $staff->save();
        
        return redirect()->route('staff.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        return view('staff.staff_edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {   
         //Validation
         $request->validate([
            'name' => 'required|min:4',
            'nrc' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'position' => 'required',
        ]);
        $this->authorize('update', $staff);
        //fileupload
        if($request->hasfile('image'))
        {
            $photo = $request->file('image');
            $name = time().'.'. $photo->getClientOriginalExtension();
            $photo->move(public_path().'/images/staff/',$name);
            $photo = '/images/staff/'. $name;
            $oldImg = request('oldimg');
            File::delete(public_path($oldImg));
        }
        else
        {
            $photo = request('oldimg');
        }

        // store data
        $staff->name = request('name');
        $staff->nrc = request('nrc');
        $staff->image = $photo;
        $staff->address = request('address');
        $staff->phone = request('phone');
        $staff->email = request('email');
        $staff->position = request('position');
        $staff->remark = request('remark');

        $staff->save();
        
        return redirect()->route('staff.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        $this->authorize('delete', $staff);
        $image = $staff->image;
        File::delete(public_path($image));
        $staff->delete();
        return redirect()->route('staff.index');
    }
}
