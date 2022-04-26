@extends('dashboard')

@section('content')
<div class="main-content-inner p-3">
    <h3>Popular Item/Service</h3>
    <div class="row mt-3">
        <div class="col-lg-6 mb-2">
            <div  class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Item</h5>
                    <div class="row">
                        <div class="col-6">
                            <select class="form-select" id="item-month">
                              <option selected disabled>Choose Month...</option>
                              <option value="1">January</option>
                              <option value="2">February</option>
                              <option value="3">March</option>
                              <option value="4">April</option>
                              <option value="5">May</option>
                              <option value="6">June</option>
                              <option value="7">July</option>
                              <option value="8">August</option>
                              <option value="9">Setember</option>
                              <option value="10">October</option>
                              <option value="11">November</option>
                              <option value="11">December</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select class="form-select" id="item-year">
                              <option selected disabled>Choose Year...</option>
                              @foreach($years as $year)
                                <option value="{{$year}}">{{$year}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item</th>
                            <th scope="col">Quantity</th>
                          </tr>
                        </thead>
                        <tbody class="" id="jshow-item">

                        </tbody>
                        <tbody class="" id="show-item">
                            @php
                                $i =1
                            @endphp
                            @foreach($countItems as $key=>$countItem)
                              <tr>
                                <th scope="row">{{$i++}}</th>
                                <td>{{$key}}</td>
                                <td>{{$countItem}}</td>
                              </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-2">
            <div  class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Serivces</h5>
                    <div class="row">
                        <div class="col-6">
                            <select class="form-select" id="service-month">
                              <option selected disabled>Choose Month...</option>
                              <option value="1">January</option>
                              <option value="2">February</option>
                              <option value="3">March</option>
                              <option value="4">April</option>
                              <option value="5">May</option>
                              <option value="6">June</option>
                              <option value="7">July</option>
                              <option value="8">August</option>
                              <option value="9">Setember</option>
                              <option value="10">October</option>
                              <option value="11">November</option>
                              <option value="11">December</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <select class="form-select" id="service-year">
                              <option selected disabled>Choose Year...</option>
                              @foreach($years as $year)
                                <option value="{{$year}}">{{$year}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Service</th>
                            <th scope="col">Quantity</th>
                          </tr>
                        </thead>
                        <tbody class="" id="jshow-service">

                        </tbody>
                        <tbody class="" id="show-service">
                            @php
                                $is =1
                            @endphp
                            @foreach($countServices as $key=>$countService)
                              <tr>
                                <th scope="row">{{$is++}}</th>
                                <td>{{$key}}</td>
                                <td>{{$countService}}</td>
                              </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('js/popular.js')}}"></script>
@endsection
