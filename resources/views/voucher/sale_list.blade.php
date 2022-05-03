@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <form method="GET" action="{{route('salelist')}}">
        @csrf
            <div class="mt-3 mb-2 d-flex ">
            <div class="form-group row mr-3">
                <label class="col-form-label">From Date:</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control form-control-sm" name="fromdate" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label">To Date:</label>
                <div class="col-sm-8">
                    <input type="date" class="form-control form-control-sm" name="todate" />
                </div>
            </div>
            <div class="row align-self-end">
                <div class="col-12">
                    <div class="input-group">
                        <input type="search" placeholder="Search here" class="form-control"  name="search" />
                        <input type="submit" class="btn btn-outline-primary" value="Search"/>
                        @if($searched)
                            <a href="{{route('salelist')}}" class="btn btn-outline-info">Clear Search</a>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </form>
        <table class="table table-hover progress-table text-center" id="myTable1">
            <thead class="text-uppercase">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Voucher Number</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                    <th scope="col">Source</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($itemVouchers as $key=>$itemVoucher)
                    <tr>
                        <th>{{$key+1}}</th>
                        <td>{{$itemVoucher->voucher->voucher_number}}</td>
                        <td>{{$itemVoucher->voucher->customer->name}}</td>
                        <td>{{$itemVoucher->item->name}}</td>
                        <td>{{$itemVoucher->quantity}}</td>
                        <td>{{$itemVoucher->item_price}} Ks</td>
                        <td>{{$itemVoucher->quantity * $itemVoucher->item_price}} Ks</td>
                        <td>{{$itemVoucher->source}}</td>
                        <th>{{$itemVoucher->date}}</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $itemVouchers->appends(Request::except('page'))->links("pagination::bootstrap-5") }}

        @if(Session::has("saleexport"))
            <div class="d-flex justify-content-end mt-3">
                <a class="btn btn-primary" href="{{route('saleexport')}}">Export Excel</a>
            </div>
        @endif
    </div>
@endsection('content')