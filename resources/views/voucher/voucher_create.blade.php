@include('partials/heading')
<div class="header-area">
    <div class="row align-items-center">
        <!-- nav and search button -->
        <div class="col-sm-6">

            <div class=" d-flex justify-content-start align-items-center">
                <div class="my-auto m-1">
                    <a href="./index.php">
                        <i class="fa fa-arrow-left fw-bolder" style="color:#7801ff;"></i>
                    </a>
                </div>
                <h4 class="page-title pull-left">Customer appointment</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="index.php">Home</a></li>
                    <li><span>Dashboard</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix row d-flex justify-content-end align-items-center">
            <div class="user-profile  pull-right col-sm-11 d-flex justify-content-end pr-2">
                <img class="avatar user-thumb" src="assets/images/author/avatar.png" alt="avatar">
                <h4 class="user-name text-dark dropdown-toggle" data-toggle="dropdown">minkhant <i
                        class="fa fa-angle-down"></i></h4>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Log Out</a>
                </div>
            </div>
            <ul class="notification-area pull-right col-sm-1 pr-0">
                <li id="full-view"><i class="fa fa-expand"></i></li>
                <li id="full-view-exit"><i class="fa fa-compress"></i></li>
            </ul>
        </div>
    </div>
</div>
<div class="container-fluid" style="background-color:silver">
    <div class="mt-2 me-2">
        <div class="row">
            <div class="col-2 add-customer-content">
                <div class="add-customer my-2">
                    <div class="btn-group w-100">
                        <!-- <input type="text" class="form-control form-control-sm"> -->
                        <select name="" id="voucher-select-cust" class="form-select form-select-sm" required>
                            <option value="" disabled>select customer ...</option>
                            @foreach($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        </select>
                        <button id="voucher-add" class="btn btn-sm btn-info">Add</button>
                    </div>
                </div>
                <hr>
                <div class="customer-app">
                    <ul class="list-group" style="height: 450px;
    overflow-y: auto;" id="customer-check">
                       
                    </ul>
                </div>
            </div>
            <div class="col-10">
                <div class="p-2">
                    <h5>
                        Voucher Id - <span id="voucher-id"></span>
                    </h5>
                </div>
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-3">
                        <h6>Customer - <span id="customer-name"></span></h6>
                    </div>
                    <div class="col-3">
                        <input type="date" class="form-control form-control-sm col-3">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-5">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-start">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="radio" name="item_or_sevice" id="item"
                                        value="item">
                                    <label for="item" class="form-check-label">Item</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="item_or_sevice" id="service"
                                        value="service">
                                    <label for="service" class="form-check-label">Service</label>
                                </div>
                            </div>
                            <div class="card-body" style="height: 450px;
    overflow-y: auto;">
                                <!-- <select class="form-select">
                                    <option value="">select here ..</option>
                                </select> -->
                                <div class="item-box row d-none">
                                    @foreach($items as $item)
                                    <div class="col-4 item-btn-wapper mb-2">
                                        <button class="item-button btn btn-secondary"
                                        onclick="addItem('{{$item->id}}','{{$item->name}}','{{$item->price}}')">
                                            {{$item->name}}
                                        </button>
                                    </div>       
                                    @endforeach
                                </div>
                                <div class="service-box row d-none">
                                    @foreach($services as $service)
                                    <div class="col-4 service-btn-wapper mb-2">
                                        <button class="service-button btn btn-secondary">
                                            {{$service->name}}
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="card mb-2">
                            <div class="card-body s_item_card">
                                <table align="center" class="table table-bordered mx-auto text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-dark">No.</th>
                                            <th class="text-dark">Item Name</th>
                                            <th class="text-dark">Quantity</th>
                                            <th class="text-dark">Price</th>
                                            <!-- <th style="text-align:center;" class="text-dark">Source</th> -->
                                            <!-- <th style="text-align:center;">Stock Price</th> -->
                                            <th class="text-dark">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="addMoreItem" id="items-table">
                                        <tr>
                                            <td class="text-dark"><b>1</b></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" readonly>
                                            </td>
                                            <td>
                                                <input name="" id="" type="number" class="form-control form-control-sm"
                                                    required>
                                            </td>
                                            <td>
                                                <input name="" id="" type="text" class="form-control form-control-sm"
                                                    readonly>
                                            </td>
                                            <!-- <td>
                                            <input name="" id="" type=""
                                                class="form-control form-control-sm discount">

                                            </td> -->
                                            <td>
                                                <input name="" id="" type="text" class="form-control form-control-sm "
                                                    readonly>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm text-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mb-2">
                            <div class="card-body s_service_card">
                                <table align="center" class="table table-bordered mx-auto text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-dark">No.</th>
                                            <th class="text-dark">Service</th>
                                            <th class="text-dark">Qty</th>
                                            <th class="text-dark">Unit Price</th>
                                            <!-- <th style="text-align:center;" class="text-dark">Source</th> -->
                                            <!-- <th style="text-align:center;">Stock Price</th> -->
                                            <th class="text-dark">Staff</th>
                                            <th class="text-dark">Amount</th>
                                            <th>
                                                <!-- <a class="btn btn-sm btn-success add_more rounded-circle">
                                            <i class="fa fa-plus"></i>
                                        </a> -->
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="addMoreItem">
                                        <tr>
                                            <td class="text-dark"><b>1</b></td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" readonly>
                                            </td>
                                            <td>
                                                <input name="" id="" type="number" class="form-control form-control-sm"
                                                    required>
                                            </td>
                                            <td>
                                                <input name="" id="" type="text" class="form-control form-control-sm"
                                                    readonly>
                                            </td>
                                            <!-- <td>
                                            <input name="" id="" type=""
                                                class="form-control form-control-sm discount">

                                            </td> -->
                                            <td>
                                                <input name="" id="" type="text" class="form-control form-control-sm"
                                                    readonly>
                                            </td>
                                            <td>
                                                <input name="" id="" type="text" class="form-control form-control-sm"
                                                    readonly>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm text-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card s_invoice mb-2">
                            <div class="card-body row">
                                <div class="col-5">
                                    <label for="remark">Remark</label>
                                    <textarea name="" id="remark" cols="30" rows="10" style="resize: none;"></textarea>
                                </div>
                                <div class="col-7 row">
                                    <div class="col-12 mt-auto">
                                        <div class="form-group w-100 mb-2 d-flex align-items-center">
                                            <label for="" class="form-label me-3">Total </label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                        <div class="form-group w-100 mb-2 d-flex align-items-center">
                                            <label for="" class="form-label me-3">Paid </label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                        <div class="form-group w-100 mb-2 d-flex align-items-center">
                                            <label for="" class="form-label me-3">Discount </label>
                                            <input type="text" class="form-control form-control-sm">
                                        </div>
                                        <div class="form-group d-flex justify-content-between row">
                                            <button class="btn btn-secondary col-4" style="height: 80px;">print</button>
                                            <button class="btn btn-secondary col-7" style="height: 80px;">print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials/footer')