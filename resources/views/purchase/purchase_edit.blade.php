@extends('dashboard')

@section('content')
<div class="card bg-light">
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal"  method="POST" action="{{ route('purchase.update', $purchase) }}">
        @csrf
        @method('PUT')
        <div class="card-body col-md-10">
            <h2 class="py-2 mb-4 d-flex align-items-center">Update Purchase Item</h2>

            <div class="form-group row">
                <label for="purchase_item" class="form-label col-sm-2">Purchase Item :</label>
                <!-- <input class="form-control col-sm-10 mb-2" type="text" id="purchase_item" /> -->
                <select name="item_id" id="" class="form-control col-sm-10 mb-2" disabled>
                    <option value="" class="" selected disabled>Select Item</option>
                    @foreach($items as $item)
                        <option value="{{$item->id}}"
                        @if($item->id == $purchase->item_id)
                            {{'selected'}}
                        @endif    
                        >{{$item->name}}</option>
                    @endforeach
                </select>
                @error('item_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="items_type" class="form-label col-sm-2">Purchase Date :</label>
                <input class="form-control col-sm-10 mb-2" type="date" id="items_type" 
                name="date" value="{{$purchase->date}}"/>
                @error('date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- <div class="form-group row">
                <label for="items code" class="form-label col-sm-2">Source :</label>
                <select name="" id="" class="form-control col-sm-10 mb-2">
                    <option value="" selected>Select Source</option>
                    <option value="" class="">Counter</option>
                    <option value="" class="">Default</option>
                </select>
            </div> -->
            <div class="form-group row">
                <label for="quantity" class="form-label col-sm-2">Quantity :</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="quantity" 
                name="quantity" value="{{$purchase->quantity}}"/>
                <input type="hidden" name="oldQty" value="{{$purchase->quantity}}">
                @error('quantity')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="cost" class="form-label col-sm-2">Purchase Price :</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="cost" 
                name="purchase_price" value="{{$purchase->purchase_price}}"/>
                @error('purchase_price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="remark" class="form-label col-sm-2">Remark:</label>
                <textarea style="resize: none; padding-top: 35px; height:200px;" class="form-control col-sm-10 mb-2"
                    type="tel" id="remark" name="remark">{{$purchase->remark}}</textarea>
            </div>
            <div class="mt-3 d-flex justify-content-end">
                <div>
                    <a href="{{route('purchase.index')}}" class="btn btn-lg btn-default mr-3">Cancel</a>
                    <button type="submit" class="btn btn-lg text btn-info "> Update <i
                            class="ml-1 fa fa-plus"></i></button>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </form>
</div>
@endsection