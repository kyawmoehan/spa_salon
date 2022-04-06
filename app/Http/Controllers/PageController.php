<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
        // $this->middleware('role:user');
    }

    
    public function dashboard(){
        return view('home/home');
    }
}
