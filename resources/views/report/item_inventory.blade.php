@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <div class="mt-3 mb-3">
        <form method="GET" action="{{route('iteminventory')}}">
            @csrf
            <div class="d-flex">
                <input type="search" placeholder="Search here" class=""  name="search" />
                <button type="submit" >Search</button>
                @if($searched)
                    <a href="{{route('iteminventory')}}" >Clear Search</a>
                @endif
            </div>
        </form>
    </div >
    <table class="table table-hover progress-table text-center" id="myTable1">
        <thead class="text-uppercase">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Item Name</th>
                <th scope="col">Opening Stock</th>
                <th scope="col">Counter Stock</th>
                <th scope="col">Purchase Stock</th>
                <th scope="col">Sold Stock</th>
                <th scope="col">Closing Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itemList as $key=>$item)
            <tr>
                <th>{{$key+1}}</th>
                <td>{{$item->item->name}}</td>
                <td>0</td>
                <td>{{$item->counter}}</td>
                <td>{{$item->purchase}}</td>
                <td>0</td>
                <td>0</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $itemList->appends(Request::except('page'))->links("pagination::bootstrap-5") }}
</div>
@endsection