@extends('dashboard')

@section('content')
<div class="card bg-light">
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="POST" action="{{ route('staff.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card-body col-md-10">
            <h2 class="py-2 mb-4 d-flex align-items-center">Add Staff</h2>

            <div class="form-group row">
                <label for="Name" class="form-label col-sm-2">Name :</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="Name" name="name"/>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="nrc" class="form-label col-sm-2">NRC :</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="nrc" name="nrc"/>
                @error('nrc')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="profile_image" class="form-label col-sm-2">Profile image :</label>
                <input class="form-control col-sm-10 mb-2" type="file" id="profile_image" name="image" />
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="address" class="form-label col-sm-2">Address :</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="address" name="address"/>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="phone" class="form-label col-sm-2">Phone :</label>
                <input class="form-control col-sm-10 mb-2" type="tel" id="phone" name="phone"/>
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="email" class="form-label col-sm-2">Email :</label>
                <input class="form-control col-sm-10 mb-2" type="email" id="email" name="email"/>
            </div>
            <div class="form-group row">
                <label for="position" class="form-label col-sm-2">Position :</label>
                <!-- <input class="form-control col-sm-10 mb-2" type="text" id="phone" /> -->
                <select name="position" class="form-control col-sm-10 mb-2" id="position">
                    <option value="" class="text-light" selected>Select Position</option>
                    <option value="manager">Manager</option>
                    <option value="service">Service Staff</option>
                    <option value="sale">Sale Staff</option>
                </select>
                @error('position')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="status" class="form-label col-sm-2">Status :</label>
                <!-- <input class="form-control col-sm-10 mb-2" type="text" id="phone" /> -->
                <select name="status" class="form-control col-sm-10 mb-2" id="status">
                    <option value="1" class="text-light" selected>Avaliable</option>
                    <option value="0">Unavaliable</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="remark" class="form-label col-sm-2">Remark :</label>
                <textarea style="resize: none; padding-top: 35px; height:200px;" class="form-control col-sm-10 mb-2"
                    type="text" id="remark" name="remark"></textarea>
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