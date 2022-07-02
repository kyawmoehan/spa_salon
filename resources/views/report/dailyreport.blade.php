@extends('dashboard') @section('content')
<div class="main-content-inner">
    <h3>Services</h3>
    <table class="table table-hover progress-table text-center" id="myTable1">
        <thead class="text-uppercase">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Services</th>
                <th scope="col">Quanttiy</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $serviceTotal = 0; 
            @endphp 
            @foreach($report['services'] as $key=>$service)
            <tr>
                <th>{{ $key + 1 }}</th>
                <th>{{ $service['detail']->name }}</th>
                <th>
                    {{ $service["quantity"] }}
                </th>
                <th>
                    {{ $service['detail']->price * $service['quantity'] }} Ks
                </th>
                @php 
                    $serviceTotal += $service['detail']->price * $service['quantity']; 
                @endphp
            </tr>
            @endforeach
            <tr>
                <th colspan="3" class="h5">Total Amount</th>
                <th class="h5">{{ $serviceTotal }} Ks</th>
            </tr>
        </tbody>
    </table>
    <h3>Items</h3>
     <table class="table table-hover progress-table text-center" id="myTable1">
        <thead class="text-uppercase">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Items</th>
                <th scope="col">Quanttiy</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $itemTotal = 0; 
            @endphp 
            @foreach($report['items'] as $key=>$item)
            <tr>
                <th>{{ $key + 1 }}</th>
                <th>{{ $item['detail']->name }}</th>
                <th>
                    {{ $item["quantity"] }}
                </th>
                <th>
                    {{ $item['detail']->price * $item['quantity'] }} Ks
                </th>
                @php 
                    $itemTotal += $item['detail']->price * $item['quantity']; 
                @endphp
            </tr>
            @endforeach
            <tr>
                <th colspan="3" class="h5">Total Amount</th>
                <th><p class="h5">{{ $itemTotal }} Ks</p></th>
            </tr>
        </tbody>
    </table>
</div>
@endsection
