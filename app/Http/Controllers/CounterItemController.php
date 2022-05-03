<?php

namespace App\Http\Controllers;

use App\Models\CounterItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Carbon;
use App\Http\Controllers\ItemLisstController;
use Session;

class CounterItemController extends Controller
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
        $this->authorize('viewAny', CounterItem::class);
        Session::put('currentpage', "Counter Item List");
        $allCounter= CounterItem::query();
        $searched = false;
        if(request('fromdate') && request('todate') && request('search')){
            $from = request('fromdate');
            $to = request('todate');
            $data = request('search');
            $allCounter->whereBetween('date', [$from, $to])->whereHas('item', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");          
            });
            $searched = true;
        }else if(request('fromdate') && request('todate')){
            $from = request('fromdate');
            $to = request('todate');
            $allCounter->whereBetween('date', [$from, $to])->get();
            $searched = true;
        }else if (request('search')) {
            $data = request('search');
            $allCounter->whereHas('item', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");          
            });
            $searched = true;
        }
       
        $counterItems = $allCounter->orderByDesc('date')->paginate(15);
        return view('counter.counter_list', compact(['counterItems', 'searched']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Session::put('currentpage', "Counter Item Create");
        $items = Item::all();
        return view('counter.counter_create', compact('items'));
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
            'item_id' => 'required',
            'date' => 'required',
            'quantity' => 'required',
            'purchase_price' => 'required',
        ]);

        $this->authorize('create', CounterItem::class);

        // store data 
        $counter = new CounterItem();
        $counter->item_id = request('item_id');
        $counter->date = Carbon\Carbon::parse($request->date);
        $counter->quantity = request('quantity');
        $counter->purchase_price = request('purchase_price');
        $counter->remark = request('remark');
       
        $counter->save();
          
        // item list
        (new ItemListController)->addItem(request('item_id'), 'counter', request('quantity'));
        
        return redirect()->route('counter.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CounterItem  $counterItem
     * @return \Illuminate\Http\Response
     */
    public function show(CounterItem $counterItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CounterItem  $counterItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CounterItem $counter)
    {
        Session::put('currentpage', "Counter Item Update");
        $items = Item::all();
        return view('counter.counter_edit', compact(['counter', 'items']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CounterItem  $counterItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CounterItem $counter)
    {
        //Validation
        $request->validate([
            'date' => 'required',
            'quantity' => 'required',
            'purchase_price' => 'required',
        ]);

        $this->authorize('update', $counter);

         // store data 
        $counter->date = Carbon\Carbon::parse($request->date);
        $counter->quantity = request('quantity');
        $counter->purchase_price = request('purchase_price');
        $counter->remark = request('remark');
       
        $counter->save();
        
        //item lsit 
        if(request('quantity') > request('oldQty')){
            $quantity = request('quantity') - request('oldQty');
            (new ItemListController)->addItem($counter->item_id, 'counter', $quantity);
        }else if(request('quantity') < request('oldQty')){
            $quantity = request('oldQty') - request('quantity');
            (new ItemListController)->removeItem($counter->item_id, 'counter', $quantity);
        }
          
        return redirect()->route('counter.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CounterItem  $counterItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CounterItem $counter)
    {
        $this->authorize('delete', $counter);
        $counter->delete();
        (new ItemListController)->removeItem($counter->item_id, 'counter', $counter->quantity);
        return redirect()->route('counter.index');
    }
}
