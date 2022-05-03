<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Session;

class TypeController extends Controller
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
        $this->authorize('viewAny', Type::class);
        Session::put('currentpage', "Item Type List");
        $types = Type::paginate(15);
        return view('type.type_list', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('currentpage', "Item Type Create");
        return view('type.type_create');
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
        ]);

        $this->authorize('create', Type::class);

        // store data 
        $type = new Type();
        $type->name = request('name');
        $type->save();
        
        return redirect()->route('type.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        Session::put('currentpage', "Item Type Update");
        return view('type.type_edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        //Validation
        $request->validate([
            'name' => 'required|min:4',
        ]);

        $this->authorize('update', $type);

        // store data 
        $type->name = request('name');
        $type->save();
        
        return redirect()->route('type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $this->authorize('delete', $type);
        $type->delete();
        return redirect()->route('type.index');
    }
}
