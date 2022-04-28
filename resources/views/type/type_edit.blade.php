@extends('dashboard')

@section('content')
<div class="card bg-light">
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="POST" action="{{ route('type.update', $type) }}">
        @csrf
        @method('PUT')
        <div class="card-body col-md-10">
            <h2 class="py-2 mb-4 d-flex align-items-center">Update Item Type</h2>
            <div class="form-group row">
                <label for="Name" class="form-label col-sm-2">Name</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="Name" name="name" 
                value="{{$type->name}}"/>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- /.card-body -->
            <div class="mt-3 d-flex justify-content-end">
                <div>
                    <a  href="{{route('type.index')}}" class="btn btn-lg btn-default mr-3">Cancel</a>
                    <button type="submit" class="btn btn-lg text btn-info "> Update <i
                            class="ml-1 fa fa-plus"></i></button>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </form>
</div>
@endsection