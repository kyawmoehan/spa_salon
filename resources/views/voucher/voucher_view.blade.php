@extends('dashboard')

@section('content')
    <div class="main-content-inner">
        <div class="d-flex justify-content-between mb-2 mt-2">
            <h4>Voucher Number: {{$voucher->voucher_number}}</h4>
            <h4>Casher: {{$voucher->user->name}}</h4>
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
                        <td>{{$item->item_price}}</td>
                        <td>{{$item->item_price*$item->quantity}}</td>
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
                        <td>{{$staff->service->price}}</td>
                        <td>{{$staff->staff->name}}</td>
                        <td>{{$staff->staff_pct}}</td>
                        <td>{{$staff->staff_amount}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection