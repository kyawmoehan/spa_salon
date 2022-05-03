@extends('dashboard')

@section('content')
<div class="main-content-inner">
    <h3 class="mt-3">Backup Data</h3>
    <form action="{{ route('getbackupdatabase') }}" method="get" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-primary"> Backup All Data</button>
    </form>
</div>
@endsection