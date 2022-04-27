@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <div class="mt-3 mb-3">
        <form method="GET" action="{{route('customer.index')}}">
            @csrf
            <div class="row justify-content-end">
                <div class="col-4">
                    <div class="input-group">
                        <input type="search" placeholder="Search here" class="form-control"  name="search" />
                        <input type="submit" class="btn btn-outline-primary" value="Search"/>
                        @if($searched)
                            <a href="{{route('customer.index')}}" class="btn btn-outline-info">Clear Search</a>
                        @endif
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