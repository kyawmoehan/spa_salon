@extends('dashboard')

@section('content')
<div class="main-content-inner">
       <form class="form-horizontal" method="POST" action="{{ route('iteminventoryupdate', $itemList) }}">
        @csrf
        @method('PUT')
        <div class="card-body col-md-10">
            <h2 class="py-2 mb-4 d-flex align-items-center">Update Items List</h2>
            <div class="form-group row">
                <label for="name" class="form-label col-sm-2">Item Name:</label>
                <input class="form-control col-sm-10 mb-2" type="text" id="name" name="name" 
                value="{{$itemList->item->name}}" disabled/>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="counter" class="form-label col-sm-2">Countet:</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="counter" name="counter"
                value="{{$itemList->counter}}"/>
                @error('counter')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="purchase" class="form-label col-sm-2">Purchase:</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="purchase" name="purchase"
                value="{{$itemList->purchase}}"/>
                @error('purchase')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- /.card-body -->
            <div class="mt-3  d-flex justify-content-end">
                <div >
                    <a  href="{{route('iteminventory')}}" class="btn btn-lg btn-default mr-3">Cancel</a>
                    <button type="submit" class="btn btn-lg text btn-info "> Update 
                        <i class="ml-1 fa fa-plus"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </form>
</div>
@endsection