@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <form method="GET" action="{{route('staff.index')}}" class="mt-2">
        @csrf
        <div class="row justify-content-end">
            <div class="col-4">
                <div class="input-group mb-3">
                    <input type="search" placeholder="Search here" class="form-control"  name="search" />
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-secondary" >Search</button>
                        @if($searched)
                            <a href="{{route('staff.index')}}" class="btn btn-outline-info">Clear Search</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
    <table class="table table-hover progress-table text-center" id="myTable1">
        <thead class="text-uppercase">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">NRC</th>
                <th scope="col">Img</th>
                <th scope="col">Address</th>
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
                <th scope="col">Position</th>
                <th scope="col">Remark</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($all_staff as $key=>$staff)
            <tr>
                <th>{{$key+1}}</th>
                <td>{{$staff->name}}</td>
                <td>{{$staff->nrc}}</td>
                <td><img src="{{asset($staff->image)}}" alt="" width="50" height="50"></td>
                <td>{{$staff->address}}</td>
                <td>{{$staff->phone}}</td>
                <td>{{$staff->email}}</td>
                <td>{{$staff->position}}</td>
                <td>{{$staff->remark}}</td>
                <td>
                    <ul class="d-flex justify-content-center">
                        <li class="mr-3"><a href="{{route('staff.edit', $staff)}}" class="text-secondary"><i class="fa fa-edit"></i></a>
                        </li>
                        <li>
                            <form action="{{route('staff.destroy', $staff)}}" method="POST"
                                class="d-inline-block" onsubmit="return confirm('Are you sure?')" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-0 btn text-danger">
                                        <i class="ti-trash"></i>
                                    </button>
                                <!-- <a  href="#" class="text-danger"><i class="ti-trash"></i></a> -->
                            </form> 
                        </li>
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
        {{ $all_staff->appends(Request::except('page'))->links("pagination::bootstrap-5") }}
    </table>
    <div class="mt-3">
        <a href="{{route('staff.create')}}"
            class="btn mt-auto btn-info ml-auto mb-2 col-sm-1 d-flex justify-content-center align-items-center">
            <i class="ti-plus mr-2 fw-bold"></i> Add
        </a>
    </div>
</div>
@endsection