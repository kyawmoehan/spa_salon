<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Carbon;

class PurchaseItemController extends Controller
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
        $this->authorize('viewAny', PurchaseItem::class);
        $allPurchase= PurchaseItem::query();
        $searched = false;
        if(request('fromdate')){
            $from = request('fromdate');
            $to = request('todate');
            $allPurchase->whereBetween('date', [$from, $to])->get();
            $searched = true;
        }else if (request('search')) {
            $data = request('search');
            $allPurchase->whereHas('item', function($query) use ($data) {
                $query
                ->where('name', 'Like', "%{$data}%");          
            });
            $this->page = 1;
            $searched = true;
        }
       
        $purchaseItems = $allPurchase->orderByDesc('date')->paginate(20);
        return view('purchase.purchase_list', compact(['purchaseItems', 'searched']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::all();
        return view('purchase.purchase_create', compact('items'));
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

        $this->authorize('create', PurchaseItem::class);

         // store data 
        $purchase = new PurchaseItem();
        $purchase->item_id = request('item_id');
        $purchase->date = Carbon\Carbon::parse($request->date);
        $purchase->quantity = request('quantity');
        $purchase->purchase_price = request('purchase_price');
        $purchase->remark = request('remark');
       
        $purchase->save();
          
        return redirect()->route('purchase.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseItem $purchaseItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseItem $purchase)
    {
        $items = Item::all();
        return view('purchase.purchase_edit', compact(['purchase', 'items']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseItem $purchase)
    {
        //Validation
        $request->validate([
            'item_id' => 'required',
            'date' => 'required',
            'quantity' => 'required',
            'purchase_price' => 'required',
        ]);

        $this->authorize('update', $purchase);

         // store data 
        $purchase->item_id = request('item_id');
        $purchase->date = Carbon\Carbon::parse($request->date);
        $purchase->quantity = request('quantity');
        $purchase->purchase_price = request('purchase_price');
        $purchase->remark = request('remark');
       
        $purchase->save();
          
        return redirect()->route('purchase.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseItem  $purchaseItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseItem $purchase)
    {
        $this->authorize('delete', $purchase);
        $purchase->delete();
        return redirect()->route('purchase.index');
    }
}
