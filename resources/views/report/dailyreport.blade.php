@extends('dashboard') @section('content')
<div class="main-content-inner">
    <div class="d-flex justify-content-between">
        <form method="GET" action="{{ route('daily') }}">
            @csrf
            <div class="mt-3 mb-2 d-flex align-items-end">
                <div class="form-group row mr-3">
                    <label class="col-form-label">Date:</label>
                    <div class="col-sm-8">
                        <input
                            type="date"
                            class="form-control form-control-sm"
                            name="date"
                            id="date"
                            value="{{  request('date') ?? (new DateTime())->format('Y-m-d') }}"
                        />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <input
                            type="submit"
                            class="form-control form-control-sm btn btn-primary"
                            value="Search"
                        />
                    </div>
                </div>
            </div>
        </form>
    </div>
    <h3>Services</h3>
    <table class="table table-hover progress-table text-center" id="myTable1">
        <thead class="text-uppercase">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Voucher</th>
                <th scope="col">Service</th>
                <th scope="col">Staff</th>
                <th scope="col">Staff Percentage</th>
                <th scope="col">Service Price</th>
                <th scope="col">Staff Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $serviceTotal = 0; @endphp @foreach($serviceReport as
            $key=>$service)
            <tr>
                <th>{{ $key + 1 }}</th>
                <th>{{ $service['voucherId'] }}</th>
                <th>{{ $service['service'] }}</th>
                <th>
                   
                    @foreach ($service["staff"] as $staff)
                        <p>{{ $staff }}</p>
                    @endforeach
                </th>
                <th>
                    {{ $service["percentage"] }} %
                </th>
                <th>
                    {{ $service["servicePrice"] }} Ks
                </th>
                <th>{{ $service["staffAmount"] }} Ks</th>
                @php $serviceTotal +=  $service["servicePrice"]; @endphp
            </tr>
            @endforeach
            <tr>
                <th colspan="5" class="h5">Total Amount</th>
                <th class="h5">{{ $serviceTotal }} Ks</th>
            </tr>
        </tbody>
    </table>
    <h3>Items</h3>
    <table class="table table-hover progress-table text-center" id="myTable1">
        <thead class="text-uppercase">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Voucher</th>
                <th scope="col">Items</th>
                <th scope="col">Quanttiy</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $itemTotal = 0; @endphp @foreach($itemsReport as
            $key=>$item)
            <tr>
                <th>{{ $key + 1 }}</th>
                <th>{{ $item->voucher->voucher_number }}</th>
                <th>{{ $item->item->name }}</th>
                <th>
                    {{ $item->quantity}}
                </th>
                <th>{{ $item->total}} Ks</th>
                @php $itemTotal += $item->total;
                @endphp
            </tr>
            @endforeach
            <tr>
                <th colspan="3" class="h5">Total Amount</th>
                <th>
                    <p class="h5">{{ $itemTotal }} Ks</p>
                </th>
            </tr>
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        <p class="h5 px-5">Total Amount : <span class="fw-bold">{{ $totalAmount }} Ks</span></p>
        <p class="h5">Total Paid: <spam class="fw-bold">{{ $totalPaid }} Ks</spam></p>
    </div>
</div>
@endsection
