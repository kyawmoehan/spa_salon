<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon;

use App\Models\Customer;

class PageController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
        // $this->middleware('role:user');
    }

    
    public function dashboard(){
        $new_customers = Customer::whereDate('created_at', '=', Carbon\Carbon::today())
                            ->count();
        return view('home/home', compact(['new_customers']));
    }
}
