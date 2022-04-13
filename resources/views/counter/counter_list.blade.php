@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <form method="GET" action="{{route('counter.index')}}">
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
                    <a href="{{route('counter.index')}}" class="btn btn-info">Clear Search</a>
                </div>
            </div>
            @endif
            </div>
    </form>
    <div class="mt-3 mb-3">
            <form method="GET" action="{{route('counter.index')}}">
                @csrf
                <div class="d-flex">
                    <input type="search" placeholder="Search here" class=""  name="search" />
                    <button type="submit" >Search</button>
                    @if($searched)
                        <a href="{{route('counter.index')}}" >Clear Search</a>
                    @endif
                </div>
            </form>
    </div >
        <table class="table table-hover progress-table text-center" id="myTable1">
            <thead class="text-uppercase">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Item Type</th>
                    <th scope="col">Purchase Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Purchase Date</th>
                    <th scope="col">Remark</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($counterItems as $key=>$counterItem)
                <tr>
                    <th>{{$key+1}}</th>
                    <td>{{$counterItem->item->name}}</td>
                    <td>{{$counterItem->item->type->name}}</td>
                    <td>{{$counterItem->purchase_price}}</td>
                    <td>{{$counterItem->quantity}}</td>
                    <td>{{$counterItem->date}}</td>
                    <td>{{$counterItem->remark}}</td>
                    <td>
                        <ul class="d-flex justify-content-center">
                            <li class="mr-3"><a href="{{route('counter.edit', $counterItem)}}" class="text-secondary"><i class="fa fa-edit"></i></a>
                            </li>
                            <li>
                                <form action="{{route('counter.destroy', $counterItem)}}" 
                                method="POST"
                                class="d-inline-block" onsubmit="return confirm('Are you sure?')" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-0 btn text-danger">
                                    <i class="ti-trash"></i>
                                </button>
                            </form> 
                            </li>
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $counterItems->appends(Request::except('page'))->links("pagination::bootstrap-5") }}
        <div class="mt-3">
            <a href="{{route('counter.create')}}"
                class="btn mt-auto btn-info ml-auto mb-2 col-sm-1 d-flex justify-content-center align-items-center">
                <i class="ti-plus mr-2 fw-bold"></i> Add
            </a>
        </div>
    </div>
@endsection