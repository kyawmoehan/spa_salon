<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Type;
use Illuminate\Http\Request;

class ItemController extends Controller
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
        $this->authorize('create', Item::class);
        $all_item = Item::query();
        $searched = false;
        if (request('search')) {
            $all_item
            ->where('name', 'Like', '%' . request('search') . '%')      
            ->orWhere('code', 'Like', '%' . request('search') . '%')      
            ->orWhere('unit', 'Like', '%' . request('search') . '%')        
            ->get();
            $searched = true;
        }
        $items = $all_item->orderBy('id')->paginate(10);
        return view('item.item_list', compact(['items', 'searched']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        return view('item.item_create', compact('types'));
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
            'type_id' => 'required',
            'code' => 'required',
            'price' => 'required',
            'unit' => 'required',
            'available' => 'required',
        ]);

        $this->authorize('create', Item::class);
         // store data 
         $item = new Item();
         $item->name = request('name');
         $item->type_id = request('type_id');
         $item->code = request('code');
         $item->price = request('price');
         $item->unit = request('unit');
         $item->available = request('available');
         $item->remark = request('remark');
 
         $item->save();
         
        return redirect()->route('item.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $types = Type::all();
        return view('item.item_edit', compact(['item', 'types']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'type_id' => 'required',
            'code' => 'required',
            'price' => 'required',
            'unit' => 'required',
            'available' => 'required',
        ]);
        $this->authorize('update', $item);
        // store data
        $item->name = request('name');
        $item->type_id = request('type_id');
        $item->code = request('code');
        $item->price = request('price');
        $item->unit = request('unit');
        $item->available = request('available');
        $item->remark = request('remark');
 
        $item->save();
         
        return redirect()->route('item.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        $item->delete();
        return redirect()->route('item.index');
    }
}
