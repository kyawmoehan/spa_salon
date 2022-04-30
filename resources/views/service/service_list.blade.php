@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <!-- <div class="mt-3 mb-2 d-flex align-items-end">
        <div class="form-group row mr-3">
            <label class="col-form-label">From Date:</label>
            <div class="col-sm-8">
                <input type="date" class="form-control form-control-sm" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-form-label">To Date:</label>
            <div class="col-sm-8">
                <input type="date" class="form-control form-control-sm" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <input type="submit" class="form-control form-control-sm btn btn-primary" value="Search" />
            </div>
        </div>
    </div> -->
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
                <td>{{$service->normal_pct}}</td>
                <td>{{$service->name_pct}}</td>
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