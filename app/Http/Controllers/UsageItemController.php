<?php

namespace App\Http\Controllers;

use App\Models\UsageItem;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\ItemLisstController;
use Carbon;

use App\Exports\UsageItemsExport;
use Maatwebsite\Excel\Facades\Excel;

use Session;

class UsageItemController extends Controller
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
        Session::forget('usageitemexport');
        $this->authorize('viewAny', UsageItem::class);
        $allUsage= UsageItem::query();
        $searched = false;
        if(request('fromdate') && request('todate') && request('search')){
            $from = request('fromdate');
            $to = request('todate');
            $data = request('search');
            $allUsage->whereBetween('date', [$from, $to])->whereHas('item', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");          
            });
            $searched = true;
        }else if(request('fromdate') && request('todate')){
            $from = request('fromdate');
            $to = request('todate');
            Session::put('usageitemexport', [$from, $to]);
            $allUsage->whereBetween('date', [$from, $to])->get();
            $searched = true;
        }else if (request('search')) {
            $data = request('search');
            $allUsage->whereHas('item', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");          
            });
            $searched = true;
        }
       
        $usageItems = $allUsage->orderByDesc('date')->paginate(10);
        return view('usage.usage_list', compact(['usageItems', 'searched']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $items = Item::all();
        return view('usage.usage_create', compact('items'));
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
            'source' => 'required',
        ]);
        
        $this->authorize('create', UsageItem::class);

        // get price
        $itemPrice = Item::whereId(request('item_id'))->first()->price;
        // store data 
        $usage = new UsageItem();
        $usage->item_id = request('item_id');
        $usage->date = Carbon\Carbon::parse($request->date);
        $usage->quantity = request('quantity');
        $usage->total = request('quantity')* $itemPrice;
        $usage->source = request('source');
        $usage->remark = request('remark');
       
        $usage->save();
          
        // item list
        (new ItemListController)->removeItem(request('item_id'), request('source'), request('quantity'));
        return redirect()->route('usage.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UsageItem  $usageItem
     * @return \Illuminate\Http\Response
     */
    public function show(UsageItem $usageItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UsageItem  $usageItem
     * @return \Illuminate\Http\Response
     */
    public function edit(UsageItem $usage)
    {
        $items = Item::all();
        return view('usage.usage_edit', compact(['usage', 'items']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UsageItem  $usageItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UsageItem $usage)
    {
        //Validation
        $request->validate([
            'date' => 'required',
            'quantity' => 'required',
        ]);

        $this->authorize('update', $usage);

        // get price
         $itemPrice = Item::whereId($usage->item_id)->first()->price;
        // store data 
        $usage->date = Carbon\Carbon::parse($request->date);
        $usage->quantity = request('quantity');
        $usage->total = request('quantity')* $itemPrice;
        $usage->remark = request('remark');
        
        $usage->save();
               
        //item lsit 
        if(request('quantity') > request('oldQty')){
            $quantity = request('quantity') - request('oldQty');
            (new ItemListController)->removeItem($usage->item_id, $usage->source, $quantity);
        }else if(request('quantity') < request('oldQty')){
            $quantity = request('oldQty') - request('quantity');
            (new ItemListController)->addItem($usage->item_id, $usage->source, $quantity);
        }
        return redirect()->route('usage.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UsageItem  $usageItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(UsageItem $usage)
    {
        $this->authorize('delete', $usage);
        $usage->delete();
        (new ItemListController)->addItem($usage->item_id, $usage->source, $usage->quantity);
        return redirect()->route('usage.index');
    }

    public function export() 
    {
        $value = Session('usageitemexport');
        $from = $value[0];
        $to = $value[1];
        return Excel::download(new UsageItemsExport($from, $to), 'usageitem.xlsx');
    }
}
