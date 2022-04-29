@extends('dashboard')

@section('content')
<div class="card bg-light">
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="POST" action="{{ route('customer.store') }}">
        @csrf
        <div class="card-body col-md-10">
            <h2 class="py-2 mb-4 d-flex align-items-center">Add Customer</h2>

            <div class="form-group row">
                <label for="Name" class="form-label col-sm-2">Name</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="Name" name="name"/>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="address" class="form-label col-sm-2">Address</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="address" name="address"/>
            </div>
            <div class="form-group row">
                <label for="email" class="form-label col-sm-2">Email</label>
                <input class="form-control col-sm-10 mb-2" type="email" id="email" name="email"/>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="phone" class="form-label col-sm-2">Phone</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="phone" name="phone"/>
            </div>
            <div class="form-group row">
                <label for="remark" class="form-label col-sm-2">Remark</label>
                <textarea style="resize: none; padding-top: 35px; height:200px;" class="form-control col-sm-10 mb-2"
                    type="tel" id="remark" name="remark"></textarea>
            </div>

            <!-- /.card-body -->
            <div class="mt-3 d-flex justify-content-end">
                <div>
                    <button type="submit" class="btn btn-lg text btn-info "> Add <i
                            class="ml-1 fa fa-plus"></i></button>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </form>
</div>
@endsection