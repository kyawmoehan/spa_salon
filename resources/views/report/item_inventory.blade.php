@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <div class="mt-3 mb-3">
        <form method="GET" action="{{route('iteminventory')}}">
            @csrf
            <div class="row justify-content-end">
                <div class="col-4">
                    <div class="input-group mb-3">
                        <input type="search" placeholder="Search here" class="form-control"  name="search" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-secondary" >Search</button>
                            @if($searched)
                                <a href="{{route('iteminventory')}}" class="btn btn-outline-info">Clear Search</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div >
    <table class="table table-hover progress-table text-center" id="myTable1">
        <thead class="text-uppercase">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Item Name</th>
                <th scope="col">Counter Stock</th>
                <th scope="col">Purchase Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itemList as $key=>$item)
            <tr>
                <th>{{$key+1}}</th>
                <td>{{$item->item->name}}</td>
                <td>{{$item->counter}}</td>
                <td>{{$item->purchase}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $itemList->appends(Request::except('page'))->links("pagination::bootstrap-5") }}
</div>
@endsection