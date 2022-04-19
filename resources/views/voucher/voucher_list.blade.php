@extends('dashboard')

@section('content')
    <div class="main-content-inner">
        <form method="GET" action="{{route('voucher.index')}}">
            @csrf
                <div class="mt-3 mb-2 d-flex align-items-end">
                <div class="form-group row mr-3">
                    <label class="col-form-label">From Date:</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control form-control-sm" name="fromdate" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label">To Date:</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control form-control-sm" name="todate" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input type="submit" class="form-control form-control-sm btn btn-primary" value="Search"/>
                    </div>
                </div>
                @if($searched)
                <div class="form-group row">
                    <div class="col-sm-12">
                        <a href="{{route('voucher.index')}}" class="btn btn-info">Clear Search</a>
                    </div>
                </div>
                @endif
                </div>
        </form>
        <div class="mt-3 mb-3">
            <form method="GET" action="{{route('voucher.index')}}">
                @csrf
                <div class="d-flex">
                    <input type="search" placeholder="Search here" class=""  name="search" />
                    <button type="submit" >Search</button>
                    @if($searched)
                        <a href="{{route('voucher.index')}}" >Clear Search</a>
                    @endif
                </div>
            </form>
        </div >
        <table class="table table-hover progress-table text-center" id="myTable1">
            <thead class="text-uppercase">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Voucher Number</th>
                    <th scope="col">Total Amount</th>
                    <th scope="col">Paid</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Casher</th>
                    <th scope="col">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vouchers as $key=>$voucher)
                <tr>
                    <th>{{$key+1}}</th>
                    <th>{{$voucher->voucher_number}}</th>
                    <th>{{$voucher->total}}</th>
                    <th>{{$voucher->paid}}</th>
                    <th>{{$voucher->discount}}</th>
                    <th>{{$voucher->customer->name}}</th>
                    <th>{{$voucher->user->name}}</th>
                    <th>{{$voucher->date}}</th>
                    <th>
                        <a href="{{route('voucher.show', $voucher)}}">Open</a>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $vouchers->appends(Request::except('page'))->links("pagination::bootstrap-5") }}
        <div class="mt-3">
            <a href="{{route('voucher.create')}}"
                class="btn mt-auto btn-info ml-auto mb-2 col-sm-1 d-flex justify-content-center align-items-center">
                <i class="ti-plus mr-2 fw-bold"></i> Add
            </a>
        </div>
    </div>
@endsection