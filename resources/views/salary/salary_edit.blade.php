@extends('dashboard')

@section('content')
<div class="card bg-light">
    <!-- /.card-header -->
    <!-- form start -->
    <form class="form-horizontal" method="POST" action="{{ route('salary.update', $salary) }}">
        @csrf
        @method('PUT')
        <div class="card-body col-md-10">
            <h2 class="py-2 mb-4 d-flex align-items-center">Update Salary</h2>

            <div class="form-group row">
                <label for="staff_id" class="form-label col-sm-2">Staff Name :</label>
                <select id="staff-name" class="form-control col-sm-10 mb-2" name="staff_id">
                    <option value="" selected disabled>Select Name</option>
                    @foreach($staffs as $staff)
                        <option value="{{$staff->id}}"
                        @if($staff->id == $salary->staff_id)
                            {{'selected'}}
                        @endif    
                            >
                            {{$staff->name}}
                        </option>
                    @endforeach
                </select>
                @error('staff_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="ammount" class="form-label col-sm-2">Amount :</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="amount" name="amount" value="{{$salary->amount}}"/>
                @error('amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="service" class="form-label col-sm-2">Service% :</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="service-amount" name="service_amount" value="{{$salary->service_amount}}" readonly/>
            </div>
            <div class="form-group row">
                <label for="total" class="form-label col-sm-2">Total Amount:</label>
                <input class="form-control col-sm-10 mb-2" type="number" id="total-amount" name="total_amount" value="{{$salary->total_amount}}" readonly/>
            </div>
            <div class="form-group row">
                <label for="date" class="form-label col-sm-2">Date :</label>
                <input class="form-control col-sm-10 mb-2" type="date" id="date" name="date" 
                value="{{$salary->date}}"/>
                @error('date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group row">
                <label for="remark" class="form-label col-sm-2">Remark:</label>
                <textarea style="resize: none; padding-top: 35px; height:200px;" class="form-control col-sm-10 mb-2"
                    type="tel" id="remark" name="remark">{{$salary->remark}}</textarea>
            </div>

            <!-- /.card-body -->
            <div class="mt-3 d-flex justify-content-end">
                <div>
                    <a href="{{route('salary.index')}}" class="btn btn-lg btn-default mr-3">Cancel</a>
                    <button type="submit" class="btn btn-lg text btn-info "> Update <i
                            class="ml-1 fa fa-plus"></i></button>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </form>
</div>
@endsection

@section('script')
<script src="{{asset('js/salary.js')}}"></script>
@endsection