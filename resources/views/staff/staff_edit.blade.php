@extends('dashboard')

@section('content')
<div class="card bg-light">
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="POST" action="{{ route('staff.update', $staff) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body col-md-10">
            <h2 class="py-2 mb-4 d-flex align-items-center">Update Staff</h2>

            <div class="form-group row">
                <label for="Name" class="form-label col-sm-2">Name :</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="Name" name="name"
                 value="{{$staff->name}}"/>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="nrc" class="form-label col-sm-2">NRC :</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="nrc" name="nrc"
                value="{{$staff->nrc}}"/>
                @error('nrc')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <img src="{{asset($staff->image)}}" alt="" class="col-2 img-thumbnail img-fluid" >
            <input type="hidden" name="oldimg" value="{{$staff->image}}">
            <div class="form-group row">
                <label for="profile_image" class="form-label col-sm-2">Profile image :</label>
                <input class="form-control col-sm-10 mb-2" type="file" id="profile_image" name="image" />
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="address" class="form-label col-sm-2">Address :</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="address" name="address"
                value="{{$staff->address}}"/>
                @error('address')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="phone" class="form-label col-sm-2">Phone :</label>
                <input class="form-control col-sm-10 mb-2" type="tel" id="phone" name="phone"
                value="{{$staff->phone}}"/>
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="email" class="form-label col-sm-2">Email :</label>
                <input class="form-control col-sm-10 mb-2" type="email" id="email" name="email"
                value="{{$staff->email}}"/>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="position" class="form-label col-sm-2">Position :</label>
                <!-- <input class="form-control col-sm-10 mb-2" type="text" id="phone" /> -->
                <select name="position" class="form-control col-sm-10 mb-2" id="position" >
                    <option value="" class="text-light" >Select Position</option>
                    <option value="manager" {{$staff->position == 'manager' ? 'selected': ''}}>Manager</option>
                    <option value="service" {{$staff->position == 'service' ? 'selected': ''}}>Service Staff</option>
                    <option value="sale" {{$staff->position == 'sale' ? 'selected': ''}} >Sale Staff</option>
                </select>
                @error('position')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="remark" class="form-label col-sm-2">Remark :</label>
                <textarea style="resize: none; padding-top: 35px; height:200px;" class="form-control col-sm-10 mb-2"
                    type="text" id="remark" name="remark">{{$staff->remark}}</textarea>
            </div>

            <!-- /.card-body -->
            <div class="mt-3 d-flex justify-content-end">
                <div>
                    <a href="{{route('staff.index')}}"  class="btn btn-lg btn-default mr-3">Cancel</a>
                    <button type="submit" class="btn btn-lg text btn-info "> <i class="mr-1 fa fa-plus"></i> Update
                    </button>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </form>
</div>
@endsection