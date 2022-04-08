@extends('dashboard')

@section('content')
<div class="card bg-light">
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="POST" action="{{ route('type.store') }}">
        @csrf
        <div class="card-body col-md-10">
            <h2 class="py-2 mb-4 d-flex align-items-center">Add Item Type</h2>

            <div class="form-group row">
                <label for="Name" class="form-label col-sm-2">Name</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="Name" name="name"/>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- /.card-body -->
            <div class="mt-3 form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 ml-0">
                    <button type="submit" class="btn btn-lg btn-default mr-3">Cancel</button>
                    <button type="submit" class="btn btn-lg text btn-info "> Add <i
                            class="ml-1 fa fa-plus"></i></button>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </form>
</div>
@endsection