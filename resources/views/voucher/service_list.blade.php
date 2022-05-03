@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <form method="GET" action="{{route('servicelist')}}">
        @csrf
            <div class="mt-3 mb-2 d-flex align-items-end">
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
                            <a href="{{route('servicelist')}}" class="btn btn-outline-info">Clear Search</a>
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
                    <th scope="col">Service</th>
                    <th scope="col">Service Price</th>
                    <th scope="col">Staff</th>
                    <th scope="col">Percentage</th>
                    <th scope="col">Total</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($voucherStaffs as $key=>$voucherStaff)
                    <tr>
                        <th>{{$key+1}}</th>
                        <td>{{$voucherStaff->voucher->voucher_number}}</td>
                        <td>{{$voucherStaff->voucher->customer->name}}</td>
                        <td>{{$voucherStaff->service->name}}</td>
                        <td>{{$voucherStaff->service->price}}</td>
                        <td>{{$voucherStaff->staff->name}}</td>
                        <td>{{$voucherStaff->staff_pct}} %</td>
                        <td>{{$voucherStaff->staff_amount}} Ks</td>
                        <td>{{$voucherStaff->date}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $voucherStaffs->appends(Request::except('page'))->links("pagination::bootstrap-5") }}

        @if(Session::has("serviceexport"))
            <div class="d-flex justify-content-end mt-3">
                <a class="btn btn-primary" href="{{route('serviceexport')}}">Export Excel</a>
            </div>
        @endif
    </div>
@endsection('content')