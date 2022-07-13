<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Service;
use App\Models\Staff;
use App\Models\VoucherStaff;
use App\Models\ItemVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ItemLisstController;

use App\Exports\VoucherExport;
use Maatwebsite\Excel\Facades\Excel;

use Session;

class VoucherController extends Controller
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
        Session::forget('voucherexport');
        Session::put('currentpage', "Voucher List");
        $allVouchers = Voucher::query();
        $searched = false;
        $searched1 = false;
        if (request('fromdate') && request('todate') && request("half-payment")) {
            $from = request('fromdate');
            $to = request('todate');
            Session::put('voucherexport', [$from, $to, true]);
            $allVouchers->whereBetween('date', [$from, $to])
                ->where('half_payment', '=', request("half-payment"))
                ->get();
            $searched = true;
        } else if (request('fromdate') && request('todate')) {
            $from = request('fromdate');
            $to = request('todate');
            Session::put('voucherexport', [$from, $to, false]);
            $allVouchers->whereBetween('date', [$from, $to])->get();
            $searched = true;
        } else if (request("half-payment")) {
            // Session::put('voucherexport', [null, null, true]);
            $allVouchers
                ->where('half_payment', '=', request("half-payment"))
                ->get();
            $searched = true;
        } else if (request('search')) {
            $allVouchers
                ->where('voucher_number', 'Like', '%' . request('search') . '%')
                ->orwhere('payment', 'Like', '%' . request('search') . '%')
                ->get();
            $searched1 = true;
        }
        $vouchers = $allVouchers->orderByDesc('date')->paginate(15);
        return view('voucher.voucher_list', compact(['vouchers', 'searched', 'searched1']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::orderBy('id', "DESC")->get();
        $items = Item::all();
        $services = Service::all();
        $staffs = Staff::where('status', 1)->get();
        return view('voucher.voucher_create', compact(['customers', 'items', 'services', 'staffs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $voucher = new Voucher();
        $voucher->voucher_number = $input['id'];
        $voucher->date = $input['date'];
        $voucher->customer_id = $input['customerId'];
        $voucher->total = $input['total'];
        $voucher->paid = $input['paid'];
        $voucher->payment = $input['payment'];
        $voucher->half_payment = $input['halfPayment'];
        $voucher->discount = $input['discount'];
        $voucher->discount_crash = $input['discount_crash'];
        $voucher->remark = $input['remark'];
        $voucher->voucher_staff = Auth::user()->id;
        $voucher->save();

        if (array_key_exists('services', $input)) {
            foreach ($input['services'] as $service) {
                $staff = new VoucherStaff();
                $staff->staff_id = $service['staffId'];
                $staff->service_id = $service['serviceId'];
                $staff->staff_pct = $service['staffPct'];
                $staff->staff_amount = $service['staffAmount'];
                $staff->name_checkbox = $service['nameCheckbox'] == 'true' ? 1 : 0;
                $staff->date = $input['date'];
                $voucher->voucherStaff()->save($staff);
            }
        }

        if (array_key_exists('items', $input)) {
            foreach ($input['items'] as $item) {
                $itemV = new ItemVoucher();
                $itemV->item_id = $item['itemId'];
                $itemV->quantity = $item['quantity'];
                $itemV->item_price = $item['itemPrice'];
                $itemV->total = $item['itemPrice'] * $item['quantity'];
                $itemV->source = $item['source'];
                $itemV->date = $input['date'];
                $voucher->voucherItems()->save($itemV);
                (new ItemListController)->removeItem($item['itemId'], $item['source'], $item['quantity']);
            }
        }

        $test = array_key_exists('services', $input);

        return response()->json(['success' => 'hi', 'data' => $test]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        Session::put('currentpage', "Voucher Detail");
        return view('voucher.voucher_view', compact('voucher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher $voucher)
    {
        Session::put('currentpage', "Voucher Update");
        $getItemList = $voucher->voucherItems;
        $getServiceList = $voucher->voucherStaff;
        $items = Item::all();
        $services = Service::all();
        $staffs = Staff::where('status', 1)->get();

        $itemList = [];
        foreach ($getItemList as $item) {
            $itemData = [
                'itemId' => $item->item_id,
                'itemName' => $item->item->name,
                'itemPrice' => $item->item_price,
                'quantity' => $item->quantity,
                'source' => $item->source,
            ];
            array_push($itemList, $itemData);
        }

        $serviceList = [];
        foreach ($getServiceList as $service) {
            $serviceData = [
                'nameCheckbox' => $service->name_checkbox == 1 ? true : false,
                'namePct' => $service->service->name_pct,
                'normalPct' => $service->service->normal_pct,
                'serviceId' => $service->service_id,
                'serviceName' => $service->service->name,
                'servicePrice' => $service->service->price,
                'staffAmount' => $service->staff_amount,
                'staffId' => $service->staff_id,
                'staffName' => $service->staff->name,
                'staffPct' => $service->staff_pct,
            ];
            array_push($serviceList, $serviceData);
        }


        $getData = [
            'customerId' => $voucher->customer_id,
            'customerName' => $voucher->customer->name,
            'voucherId' => $voucher->id,
            'id' => $voucher->voucher_number,
            'items' => $itemList,
            'services' => $serviceList,
        ];
        $data = json_encode($getData);
        return view('voucher.voucher_edit', compact(['voucher', 'data', 'items', 'services', 'staffs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        $this->authorize('update', $voucher);
        $input = $request->all();

        // delete old
        $oldVoucher = Voucher::find($input['voucherId']);
        if (count($oldVoucher->voucherItems) != 0) {
            foreach ($oldVoucher->voucherItems as $item) {
                (new ItemListController)->addItem(
                    $item->item_id,
                    $item->source,
                    $item->quantity
                );
            }
        }
        $oldVoucher->delete();

        // new voucher
        $voucher = new Voucher();
        $voucher->voucher_number = $input['id'];
        $voucher->date = $input['date'];
        $voucher->customer_id = $input['customerId'];
        $voucher->total = $input['total'];
        $voucher->paid = $input['paid'];
        $voucher->payment = $input['payment'];
        $voucher->half_payment = $input['halfPayment'];
        $voucher->discount = $input['discount'];
        $voucher->discount_crash = $input['discount_crash'];
        $voucher->remark = $input['remark'];
        $voucher->voucher_staff = Auth::user()->id;
        $voucher->save();

        if (array_key_exists('services', $input)) {
            foreach ($input['services'] as $service) {
                $staff = new VoucherStaff();
                $staff->staff_id = $service['staffId'];
                $staff->service_id = $service['serviceId'];
                $staff->staff_pct = $service['staffPct'];
                $staff->staff_amount = $service['staffAmount'];
                $staff->name_checkbox = $service['nameCheckbox'] == 'true' ? 1 : 0;
                $staff->date = $input['date'];
                $voucher->voucherStaff()->save($staff);
            }
        }

        if (array_key_exists('items', $input)) {
            foreach ($input['items'] as $item) {
                $itemV = new ItemVoucher();
                $itemV->item_id = $item['itemId'];
                $itemV->quantity = $item['quantity'];
                $itemV->item_price = $item['itemPrice'];
                $itemV->total = $item['itemPrice'] * $item['quantity'];
                $itemV->source = $item['source'];
                $itemV->date = $input['date'];
                $voucher->voucherItems()->save($itemV);
                (new ItemListController)->removeItem($item['itemId'], $item['source'], $item['quantity']);
            }
        }
        return response()->json(['success' => 'hi', 'data' => $input['voucherId']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        $this->authorize('delete', $voucher);
        if (count($voucher->voucherItems) != 0) {
            foreach ($voucher->voucherItems as $item) {
                (new ItemListController)->addItem(
                    $item->item_id,
                    $item->source,
                    $item->quantity
                );
            }
        }
        $voucher->delete();
        return redirect()->route('voucher.index');
    }

    public function export()
    {
        $value = Session('voucherexport');
        $from = $value[0];
        $to = $value[1];
        $halfPayment = $value[2];
        // Session::forget('voucherexport');
        return Excel::download(new VoucherExport($from, $to, $halfPayment), 'vouchers.xlsx');
    }

    public function printVoucher()
    {
        return view('voucher.print_voucher');
    }

    public function viewPrintVoucher($id)
    {
        $voucher = Voucher::find($id);
        return view('voucher.view_print_voucher', compact('voucher'));
    }
}
