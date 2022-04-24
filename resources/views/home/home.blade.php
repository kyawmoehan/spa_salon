@extends('dashboard')

@section('content')
<div class="main-content-inner p-3">
    <div class="row">
        <div class="col-lg-3 mb-2">
            <a href="./services.php" class="card  service-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7 report_text">
                            <h3 class="text-light">{{$todayServices}}</h3>
                            <p class="text-light">Today Service</p>
                        </div>
                        <div class="col-sm-5 report_icons_service">
                            <i class="fa fa-dashboard"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-transparent">
                    <div class="col service-card-more text-center p-2 text-light">
                        more info<i class="ml-2 fa fa-arrow-right"></i>
                    </div>
                </div>

            </a>
        </div>
        <div class="col-lg-3 mb-2">
            <a href="./itemList.php" class="card  item-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7 report_text">
                            <h3 class="text-light">{{$itemsStock}}</h3>
                            <p class="text-light">Items instock</p>
                        </div>
                        <div class="col-sm-5 report_icons_item">
                            <i class="fa fa-shopping-basket"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-transparent">
                    <div class="col item-card-more text-center p-2 text-light">
                        more info<i class="ml-2 fa fa-arrow-right"></i>
                    </div>
                </div>

            </a>
        </div>
        <div class="col-lg-3 mb-2">
            <a href="{{route('customer.index')}}" class="card customer-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7 report_text">
                            <h3 class="text-light">{{$new_customers}}</h3>
                            <p class="text-light">New customer</p>
                        </div>
                        <div class="col-sm-5 report_icons_customer">
                            <i class="fa fa-user"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-transparent">
                    <div class="col customer-card-more text-center p-2 text-light">
                        more info<i class="ml-2 fa fa-arrow-right"></i>
                    </div>
                </div>

            </a>
        </div>
        <div class="col-lg-3 mb-2">
            <a href="{{route('salelist')}}" class="card  sale-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7 report_text">
                            <h3 class="text-light">{{$todaySales}}</h3>
                            <p class="text-light">Today Sale</p>
                        </div>
                        <div class="col-sm-5 report_icons_sale">
                            <i class="fa fa-credit-card"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-transparent">
                    <div class="col sale-card-more text-center p-2 text-light">
                        <a class="link-light" href="{{route('salelist')}}">more info<i class="ml-2 fa fa-arrow-right"></i></a>
                    </div>
                </div>

            </a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-6 mb-2">
            <div  class="card">
                <div class="card-body">
                    <h5 class="card-title">Top Item</h5>
                    <div class="input-group mb-3">
                        <select class="form-select" id="item-month">
                          <option selected disabled>Choose...</option>
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
                    <div class="input-group mb-3">
                        <select class="form-select" id="service-month">
                          <option selected disabled>Choose...</option>
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
    <!-- <div class="card h-full col-4">
        <div class="card-body">
            <div class="chartjs-size-monitor"
                style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                <div class="chartjs-size-monitor-expand"
                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                    <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                </div>
                <div class="chartjs-size-monitor-shrink"
                    style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                    <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                </div>
            </div>
            <h4 class="header-title"></h4>
            <canvas id="chart_detail" height="242" width="313"
                style="display: block; height: 194px; width: 251px;" class="chartjs-render-monitor"></canvas>
        </div>
    </div> -->
</div>
@endsection

@section('script')
<script src="{{asset('js/home.js')}}"></script>
<script>
    if ($("#chart_detail").length) {
        var ctx = document.getElementById("chart_detail").getContext("2d");
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: "doughnut",
            // The data for our dataset
            data: {
                labels: ["Service", "Items", "Customer", "Sale"],
                datasets: [{
                    backgroundColor: [
                        "hsl(240, 100%, 50%)",
                        "hsl(115, 92%, 29%)",
                        "hsl(40, 100%, 50%)",
                        "hsl(0, 100%, 50%)",
                    ],
                    borderColor: "#fff",
                    data: [100, 50, 150, 55],
                }, ],
            },
            // Configuration options go here
            options: {
                legend: {
                    display: true,
                },
                animation: {
                    easing: "easeInOutBack",
                },
            },
        });
    }
    </script>
@endsection
