@extends('dashboard')

@section('content')
<div class="main-content-inner">

    <form method="GET" action="{{route('user.index')}}" class="mt-2">
        @csrf
        <div class="row justify-content-end">
            <div class="col-4">
                <div class="input-group mb-3">
                    <input type="search" placeholder="Search here" class="form-control"  name="search" />
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-secondary" >Search</button>
                        @if($searched)
                            <a href="{{route('user.index')}}" class="btn btn-outline-info">Clear Search</a>
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
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $key=>$user)
                <tr>
                    <th>{{$key+1}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <ul class="d-flex justify-content-center">
                            <li class="mr-3"><a href="#" class="text-secondary"><i class="fa fa-edit"></i></a>
                            </li>
                            <form action="{{route('user.destroy', $user->id)}}" method="POST"
                                class="d-inline-block" onsubmit="return confirm('Are you sure?')" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-0 btn text-danger">
                                        <i class="ti-trash"></i>
                                    </button>
                                    
                            <!-- <li><a href="#"  class="text-danger"><i class="ti-trash"></i></a></li> -->
                            </form>
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
       
    </table>
    {{ $users->appends(Request::except('page'))->links("pagination::bootstrap-5") }}
    <div class="mt-3">
        <a href="{{route('user.create')}}"
            class="btn mt-auto btn-info ml-auto mb-2 col-md-1 d-flex justify-content-center align-items-center">
            <i class="ti-plus mr-1 fw-bold"></i> Add
        </a>
    </div>
</div>
@endsection