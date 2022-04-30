@extends('dashboard')

@section('content')
    <div class="main-content-inner">
        <div class="d-flex justify-content-between mb-2 mt-2">
            <h4>Voucher Number: {{$voucher->voucher_number}}</h4>
            <div class="d-flex">
                <h4>Casher: {{$voucher->user->name}}</h4>
                @if(Auth::user()->hasRole('admin'))
                    <a href="{{route('voucher.edit', $voucher)}}" class="btn btn-info">
                        <i class="fa fa-edit"></i></a>
                    <form action="{{route('voucher.destroy', $voucher)}}" 
                    method="POST"
                    class="d-inline-block" onsubmit="return confirm('Are you sure?')" >
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="ti-trash"></i>
                        </button>
                    </form> 
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <p>Customer Name: {{$voucher->Customer->name}}</p>
                <p>Total: {{$voucher->total}} Ks</p>
                <p>Paid: {{$voucher->paid}} Ks</p>
                <p>Discount: {{$voucher->discount}} %</p>
            </div>
            <div class="col-6">
                <p>Date: {{$voucher->date}}</p>
                <p>Payment: {{$voucher->payment}}</p>
                <input class="form-check-input" type="checkbox" 
                    {{$voucher->half_payment ? 'checked': ""}}  >
                <p>Remark: {{$voucher->remark}}</p>
            </div>
        </div>
        <div class="mt-4">
            <h4>
                Itme List
            </h4>
            <table class="table table-hover progress-table text-center" id="myTable1">
                <thead class="text-uppercase">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Source</th>
                        <th scope="col">Price</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($voucher->voucherItems as $key=>$item)
                    <tr>
                        <th>{{$key+1}}</th>
                        <td>{{$item->item->name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->source}}</td>
                        <td>{{$item->item_price}} Ks</td>
                        <td>{{$item->item_price*$item->quantity}} Ks</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <h4>
                Service List
            </h4>
            <table class="table table-hover progress-table text-center" id="myTable1">
                <thead class="text-uppercase">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Service Name</th>
                        <th scope="col">Service Price</th>
                        <th scope="col">Staff Name</th>
                        <th scope="col">Staff Percentage</th>
                        <th scope="col">Staff Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($voucher->voucherStaff as $key=>$staff)
                    <tr>
                        <th>{{$key+1}}</th>
                        <td>{{$staff->service->name}}</td>
                        <td>{{$staff->service->price}} Ks</td>
                        <td>{{$staff->staff->name}}</td>
                        <td>{{$staff->staff_pct}} %</td>
                        <td>{{$staff->staff_amount}} Ks</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <a href="{{route('viewprintvoucher', $voucher->id)}}" class="btn btn-primary">Print Voucher</a>
        </div>
    </div>
@endsection