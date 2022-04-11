@extends('dashboard')

@section('content')
<div class="card bg-light">
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal"  method="POST" action="{{ route('service.update', $service) }}">
        @csrf
        @method('PUT')
        <div class="card-body col-md-10">
            <h2 class="py-2 mb-4 d-flex align-items-center">Service Update</h2>
            <div class="form-group row">
                <label for="Name" class="form-label col-sm-2">Service Name :</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="Name" name="name" 
                value="{{$service->name}}"/>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="Price" class="form-label col-sm-2">Price :</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="Price" name="price"
                value="{{$service->price}}"/>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="remark" class="form-label col-sm-2">Remark</label>
                <textarea style="resize: none; padding-top: 35px; height:200px;" class="form-control col-sm-10 mb-2"
                    type="tel" id="remark" name="remark">{{$service->remark}}</textarea>
            </div>

            <!-- /.card-body -->
            <div class="mt-3 form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 ml-0">
                    <button type="submit" class="btn btn-lg btn-default mr-3">Cancel</button>
                    <button type="submit" class="btn btn-lg text btn-info "> <i class="mr-1 fa fa-plus"></i> Update
                    </button>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </form>
</div>
@endsection