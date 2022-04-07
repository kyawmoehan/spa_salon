@extends('dashboard')

@section('content')
<div class="card bg-light">
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="POST" action="{{ route('item.store') }}">
        @csrf
        <div class="card-body col-md-10">
            <h2 class="py-2 mb-4 d-flex align-items-center">Add Items</h2>

            <div class="form-group row">
                <label for="Name" class="form-label col-sm-2">Item Type:</label>
                <select class="form-control col-sm-10 mb-2" name="type">
                    <option selected>Select Type</option>
                    <option>Type1</option>
                    <option>Type2</option>
                    <option>Type3</option>
                    <option>Type4</option>
                    <option>Type5</option>
                </select>
                @error('type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- <div class="form-group row">
                <label for="Type" class="form-label col-sm-2">Type:</label>
                <select class="form-control col-sm-10 mb-2" type="text" id="Type" />
                <option value="">Select...</option>
                </select>
            </div> -->
            <div class="form-group row">
                <label for="name" class="form-label col-sm-2">Item Name:</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="name" name="name"/>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="code" class="form-label col-sm-2">Code:</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="code" name="code"/>
                @error('code')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="Purchase_price" class="form-label col-sm-2">Purchase Price:</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="Purchase_price" name="price"/>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- <div class="form-group row">
                <label for="source" class="form-label col-sm-2">Source:</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="source" />
            </div> -->
            <div class="form-group row">
                <label for="unit" class="form-label col-sm-2">Unit:</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="unit" name="unit"/>
                @error('unit')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="available" class="form-label col-sm-2">Available:</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="available" name="available"/>
                @error('available')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            </div>
            <div class="form-group row">
                <label for="remark" class="form-label col-sm-2">Remark:</label>
                <textarea style="resize: none; padding-top: 35px; height:200px;" class="form-control col-sm-10 mb-2"
                    type="tel" id="remark" name="remark"></textarea>
            </div>
            <!-- /.card-body -->
            <div class="mt-3 form-group row">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 ml-0">
                    <button  class="btn btn-lg mr-3">Cancel
                    </button>
                    <button type="submit" class="btn btn-lg text btn-info "> Add 
                        <i class="ml-1 fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </form>
</div>
@endsection