@extends('dashboard') @section('content')
<div class="main-content-inner">
    <form method="GET" action="{{ route('salaryreport') }}">
        @csrf
        <div class="mt-3 mb-2 d-flex align-items-end">
            <div class="form-group row mr-3">
                <label class="col-form-label">From Date:</label>
                <div class="col-sm-8">
                    <input
                        type="date"
                        class="form-control form-control-sm"
                        name="fromdate"
                        value="{{  request('fromdate') }}"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label">To Date:</label>
                <div class="col-sm-8">
                    <input
                        type="date"
                        class="form-control form-control-sm"
                        name="todate"
                        value="{{  request('todate') }}"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label">Staff:</label>
                <div class="col-sm-10">
                    <select
                        id="staff-name"
                        class="form-control form-control-sm"
                        name="staff"
                    >
                        @foreach($staffs as $staff)
                        <option value="{{$staff->id}}"  @selected(request('staff') == $staff->id)  >{{$staff->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row align-self-end">
                <div class="col-12">
                    <div class="input-group">
                        <input
                            type="submit"
                            class="btn btn-outline-primary"
                            value="Search"
                        />
                    </div>
                </div>
            </div>
        </div>
    </form>
       <table class="table table-hover progress-table text-center" id="myTable1">
         <thead class="text-uppercase">
             <tr>
                 <th scope="col">#</th>
                 <th scope="col">Name</th>
                 <th scope="col">Date</th>
                 <th scope="col">Service</th>
                 <th scope="col">Percentage</th>
                 <th scope="col">Amount</th>
                 <th scope="col">By Name</th>
             </tr>
         </thead>
         @if ($data)
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach($data as $key=>$detail)
                    <tr>
                        <th>{{ $key+1 }}</th>
                        <th>{{ $detail->staff->name }}</th>
                        <th>{{ $detail->date }}</th>
                        <th>{{ $detail->service->name }}</th>
                        <th>{{ $detail->staff_pct }} %</th>
                        <th>{{ $detail->staff_amount }} Ks</th>
                        <th>{{ $detail->name_checkbox ? 'By Name': '-' }}</th>
                        @php
                            $total += $detail->staff_amount;
                        @endphp
                    </tr>
                @endforeach
                <tr>
                    <th colspan="4">Total Amount</th>
                    <th>{{ $total }} Ks</th>
                </tr>
            </tbody>
         @endif
     </table>
    @if ($data)
        <div class="d-flex justify-content-end mt-3">
            <a href="{{route('salaryreportexport')}}" class="btn btn-primary">Export Excel</a>
        </div>
    @endif
</div>
@endsection
