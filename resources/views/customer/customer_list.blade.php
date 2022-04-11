@extends('dashboard')

@section('content')
<!-- <div class="main-content-inner">
    <div class="mt-3 mb-2 d-flex align-items-end">
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
             <input type="submit" class="form-control form-control-sm btn btn-primary" value="Search"/>
           </div>
       </div>
    </div> -->
<div class="main-content-inner">
    <div class="mt-3 mb-3">
        <form method="GET" action="{{route('customer.index')}}">
            @csrf
            <div class="d-flex">
                <input type="search" placeholder="Search here" class=""  name="search" />
                <button type="submit" >Search</button>
                @if($searched)
                    <a href="{{route('customer.index')}}" >Clear Search</a>
                @endif
            </div>
        </form>
    </div >
    <table class="table table-hover progress-table text-center" id="myTable1">
        <thead class="text-uppercase">
            <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">Address</th>
                  <th scope="col">Phone Number</th>
                  <th scope="col">Email</th>
                  <th scope="col">Remark</th>
                  <th scope="col">Action</th>
            </tr>
        </thead>
          <tbody>
              @foreach($customers as $key=>$customer)
              <tr>
                  <th>{{$key+1}}</th>
                  <td>{{$customer->name}}</td>
                  <td>{{$customer->address}}</td>
                  <td>{{$customer->phone}}</td>
                  <td>{{$customer->email}}</td>
                  <td>{{$customer->remark}}</td>
                  <td>
                      <ul class="d-flex justify-content-center">
                          <li class="mr-3"><a href="{{route('customer.edit', $customer)}}" class="text-secondary"><i class="fa fa-edit"></i></a>
                          </li>
                          <li>
                            <form action="{{route('customer.destroy', $customer)}}" method="POST"
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
      {{ $customers->appends(Request::except('page'))->links("pagination::bootstrap-5") }}
      <div class="mt-3">
          <a href="{{route('customer.create')}}"
              class="btn mt-auto btn-info ml-auto mb-2 col-md-1 d-flex justify-content-center align-items-center">
              <i class="ti-plus mr-2 fw-bold"></i> Add
          </a>
      </div>
  </div>
@endsection