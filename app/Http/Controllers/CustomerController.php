<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() 
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $all_customers = Customer::query();
        $searched = false;
        if (request('search')) {
            $all_customers
            ->where('name', 'Like', '%' . request('search') . '%')
            ->orWhere('phone', 'Like', '%' . request('search') . '%')        
            ->get();
            $searched = true;
        }
        $customers = $all_customers->orderBy('id')->paginate(15);
        return view('customer.customer_list', compact(['customers', 'searched']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.customer_create');
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
            'address' => 'required',
            'phone' => 'required',
        ]);

         // store data 
         $customer = new Customer();
         $customer->name = request('name');
         $customer->address = request('address');
         $customer->phone = request('phone');
         $customer->email = request('email');
         $customer->remark = request('remark');
 
         $customer->save();
         
         return redirect()->route('customer.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customer.customer_edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //Validation
        $request->validate([
            'name' => 'required|min:4',
            'address' => 'required',
            'phone' => 'required',
        ]);
        
        // store data 
        $customer->name = request('name');
        $customer->address = request('address');
        $customer->phone = request('phone');
        $customer->email = request('email');
        $customer->remark = request('remark');

        $customer->save();
        
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customer.index');
    }
}
