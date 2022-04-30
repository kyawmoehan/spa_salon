@extends('dashboard')

@section('content')
    <div class="main-content-inner"> 
        <div class="mt-3 mb-3">
            <form method="GET" action="{{route('item.index')}}">
                @csrf
                <div class="row justify-content-end">
                    <div class="col-4">
                        <div class="input-group mb-3">
                            <input type="search" placeholder="Search here" class="form-control"  name="search" />
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary" >Search</button>
                                @if($searched)
                                    <a href="{{route('item.index')}}" class="btn btn-outline-info">Clear Search</a>
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
                    <th scope="col">Name</th>
                    <th scope="col">Item Type</th>
                    <th scope="col">Item Code</th>
                    <th scope="col">Price</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Available</th>
                    <th scope="col">Remark</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $key=>$item)
                <tr>
                    <th>{{$key+1}}</th>
                    <td>{{$item->name}}</td>
                    <td>{{$item->type->name}}</td>
                    <td>{{$item->code}}</td>
                    <td>{{$item->price}} Ks</td>
                    <td>{{$item->unit}}</td>
                    <td>{{$item->available == 1 ? "Available":"Unavailable"}}</td>
                    <td>{{$item->remark}}</td>
                    <td>
                        <ul class="d-flex justify-content-center">
                            <li class="mr-3"><a href="{{route('item.edit', $item)}}" class="text-secondary"><i class="fa fa-edit"></i></a>
                            </li>
                            <li>
                                <form action="{{route('item.destroy', $item)}}" method="POST"
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
        {{ $items->appends(Request::except('page'))->links("pagination::bootstrap-5") }}
        <div class="mt-3">
            <a href="{{route('item.create')}}"
                class="btn mt-auto btn-info ml-auto mb-2 col-sm-1 d-flex justify-content-center align-items-center">
                <i class="ti-plus mr-2 fw-bold"></i> Add
            </a>
        </div>
    </div>
@endsection