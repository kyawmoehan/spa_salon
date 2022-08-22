@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <div class="row mt-3 mb-4">
        <div class="col-4">
            <h3>Monthly Profit</h3>
        </div>
        <div class="col-4"></div>
        <div class="col-4">
            <select class="form-select" id="profit-year">
              <option selected disabled>Choose Year...</option>
              @foreach($years as $year)
                <option value="{{$year}}">{{$year}}</option>
              @endforeach
            </select>
        </div>
    </div>
    <table class="table table-hover progress-table text-center" id="myTable1">
        <thead class="text-uppercase">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Month</th>
                <th scope="col">Voucher Total</th>
                <th scope="col">Online Banking</th>
                <th scope="col">General Cost</th>
                <th scope="col">Usage Item Cost</th>
                <th scope="col">Salary Cost</th>
                <th scope="col">Profit</th>
            </tr>
        </thead>
        <tbody class="" id="jshow-profit">

        </tbody>
        <tbody class="" id="show-profit">
           @foreach($yearProfits as $key=>$profit)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$months[$key]}}</td>
                <td>{{$profit['voucherCost']}} Ks</td>
                 <td>{{$profit['onlineCost']}} Ks</td>
                <td>{{$profit['generalCost']}} Ks</td>
                <td>{{$profit['usageCost']}} Ks</td>
                <td>{{$profit['salaryCost']}} Ks</td>
                <td>{{$profit['profit']}} Ks</td>
            </tr>
           @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
        <a href="{{route('profitexport')}}" class="btn btn-primary">Export Excel</a>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('js/profit.js')}}"></script>
@endsection