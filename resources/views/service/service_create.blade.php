@extends('dashboard')

@section('content')
<div class="card bg-light">
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal"  method="POST" action="{{ route('service.store') }}">
        @csrf
        <div class="card-body col-md-10">
            <h2 class="py-2 mb-4 d-flex align-items-center">Add Service</h2>
            <div class="form-group row">
                <label for="Name" class="form-label col-sm-2">Service Name :</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="Name" name="name"/>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="Price" class="form-label col-sm-2">Price :</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="Price" name="price"/>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="normal_pct" class="form-label col-sm-2">Percentage :</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="normal_pct" name="normal_pct" step="0.1"/>
                @error('normal_pct')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="name_pct" class="form-label col-sm-2">By Name Percentage (Optional)</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="name_pct" name="name_pct" step="0.1"/>
            </div>
            
            <div class="form-group row">
                <label for="remark" class="form-label col-sm-2">Remark</label>
                <textarea style="resize: none; padding-top: 35px; height:200px;" class="form-control col-sm-10 mb-2"
                    type="tel" id="remark" name="remark"></textarea>
            </div>

            <!-- /.card-body -->
            <div class="mt-3 d-flex justify-content-end">
                <div>
                    <button type="submit" class="btn btn-lg text btn-info "> <i class="mr-1 fa fa-plus"></i> Add
                    </button>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </form>
</div>
@endsection