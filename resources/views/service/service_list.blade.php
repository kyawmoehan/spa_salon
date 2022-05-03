@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <div class="mt-3 mb-3">
        <form method="GET" action="{{route('service.index')}}">
            @csrf
            <div class="row justify-content-end">
                <div class="col-4">
                    <div class="input-group mb-3">
                        <input type="search" placeholder="Search here" class="form-control"  name="search" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-secondary" >Search</button>
                            @if($searched)
                                <a href="{{route('service.index')}}" class="btn btn-outline-info">Clear Search</a>
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
                <th scope="col">Price</th>
                <th scope="col">Percentage</th>
                <th scope="col">Byname Percentage</th>
                <th scope="col">Remark</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $key=>$service)
            <tr>
                <th>{{$key+1}}</th>
                <td>{{$service->name}}</td>
                <td>{{$service->price}} Ks</td>
                <td>{{$service->normal_pct}} %</td>
                <td>{{$service->name_pct}} {{$service->name_pct ? '%': ''}}</td>
                <td>
                    {{$service->remark}}
                </td>
                <td>
                    <ul class="d-flex justify-content-center">
                        <li class="mr-3"><a href="{{route('service.edit', $service)}}" class="text-secondary"><i class="fa fa-edit"></i></a>
                        </li>
                        <li>
                          <form action="{{route('service.destroy', $service)}}" method="POST"
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
    </table>
    {{ $services->appends(Request::except('page'))->links("pagination::bootstrap-5") }}
    <div>
        <a href="{{route('service.create')}}"
            class="btn mt-auto btn-info ml-auto mb-2 col-sm-1 d-flex justify-content-center align-items-center">
            <i class="ti-plus mr-2 fw-bold"></i> Add
        </a>
    </div>
</div>
@endsection