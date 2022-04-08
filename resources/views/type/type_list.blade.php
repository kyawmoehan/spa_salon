@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <table class="table table-hover progress-table text-center" id="myTable1">
        <thead class="text-uppercase">
            <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">Action</th>
            </tr>
        </thead>
          <tbody>
              @foreach($types as $key=>$type)
              <tr>
                  <th>{{$key+1}}</th>
                  <td>{{$type->name}}</td>
                  <td>
                      <ul class="d-flex justify-content-center">
                          <li class="mr-3"><a href="{{route('type.edit', $type)}}" class="text-secondary"><i class="fa fa-edit"></i></a>
                          </li>
                          <li>
                            <form action="{{route('type.destroy', $type)}}" method="POST"
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
      <div class="mt-3">
          <a href="{{route('type.create')}}"
              class="btn mt-auto btn-info ml-auto mb-2 col-md-1 d-flex justify-content-center align-items-center">
              <i class="ti-plus mr-2 fw-bold"></i> Add
          </a>
      </div>
  </div>
@endsection