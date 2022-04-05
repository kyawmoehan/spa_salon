@extends('dashboard')

@section('content')
<div class="main-content-inner p-3">
    <div class="row">
        <div class="col-lg-3 mb-2">
            <a href="./services.php" class="card  service-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7 report_text">
                            <h3 class="text-light">15</h3>
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
                            <h3 class="text-light">55</h3>
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
            <a href="./items.php" class="card customer-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7 report_text">
                            <h3 class="text-light">25</h3>
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
            <a href="./saleList.php" class="card  sale-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-7 report_text">
                            <h3 class="text-light">37</h3>
                            <p class="text-light">Today Sale</p>
                        </div>
                        <div class="col-sm-5 report_icons_sale">
                            <i class="fa fa-credit-card"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-transparent">
                    <div class="col sale-card-more text-center p-2 text-light">
                        more info<i class="ml-2 fa fa-arrow-right"></i>
                    </div>
                </div>

            </a>
        </div>
    </div>
    <div class="card h-full col-4">
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
    </div>
</div>
@endsection

@section('script')
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