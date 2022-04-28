@extends('dashboard')

@section('content')
<div class="container-fluid" style="background-color:silver">
    <div class="mt-2 me-2">
        <div class="row">
            <input type="hidden" id="all-data" value="{{$data}}">
            <div class="col-12">
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
                        <input type="date" class="form-control form-control-sm col-3"
                        id="voucher-date"
                        value="{{$voucher->date}}">
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
                            <div class="card-body" style="height: 450px;overflow-y: auto;">
                                <div class="item-box row d-none">
                                    <div class="col-12 mb-3">
                                        <label for="">Item Source</label>
                                        <select name="" id="item-from" class="form-select form-select-sm" required>
                                            <option value="purchase" >Default</option>
                                            <option value="counter">Counter</option>
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <input type="text" class="form-select form-select-sm"
                                        placeholder="Search Item" required id="item-search"
                                        onkeyup="itemSearch()">
                                    </div>
                                    
                                    <div class="row d-none" id="get-show-items">

                                    </div>
                                    <div class="row" id="show-items">
                                        @foreach($items as $item)
                                            <div class="col-4 item-btn-wapper mb-2">
                                                <button class="item-button btn btn-secondary"
                                                onclick="addItem('{{$item->id}}','{{$item->name}}','{{$item->price}}')">
                                                    {{$item->name}}
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="service-box row d-none">
                                    <div class="col-6 mb-3">
                                        <label for="">Staff</label>
                                        <select name="" id="staff-select" class="form-select form-select-sm mb-1" required>
                                            <option value="" disabled>Select Staff ...</option>
                                            @foreach($staffs as $staff)
                                            <option 
                                            value="{{$staff->name}},{{$staff->id}},">
                                                {{$staff->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label f>Percentage</label>
                                        <div>
                                            <input class="form-check-input" type="checkbox" value="1" id="name-checkbox">
                                            <label class="form-check-label" for="name-checkbox">
                                              By Name
                                            </label>
                                        </div>
                                    </div>
                                    
                                    @foreach($services as $service)
                                    <div class="col-4 service-btn-wapper mb-2">
                                        <button class="service-button btn btn-secondary"
                                        onclick="addService('{{$service->id}}','{{$service->name}}','{{$service->price}}', '{{$service->normal_pct}}','{{$service->name_pct}}')">
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
                                            <th class="text-dark">Source</th>
                                            <!-- <th style="text-align:center;" class="text-dark">Source</th> -->
                                            <!-- <th style="text-align:center;">Stock Price</th> -->
                                            <th class="text-dark">Total</th>
                                            <th class="text-dark">Action</th>
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
                                            <th class="text-dark">Staff</th>
                                            <th class="text-dark">Staff Percentage</th>
                                            <th class="text-dark">Staff Amount</th>
                                            <th class="text-dark">Amount</th>
                                            <th>
                                                <!-- <a class="btn btn-sm btn-success add_more rounded-circle">
                                            <i class="fa fa-plus"></i>
                                        </a> -->
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="addMoreItem"  id="service-table">
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
                                    <textarea name="" id="voucher-remark" cols="30" rows="10" style="resize: none;">{{$voucher->remark}}</textarea>
                                </div>
                                <div class="col-7 row">
                                    <div class="col-12 mt-auto">
                                        <div>
                                            <input class="form-check-input" type="checkbox" value="1" id="half-payment"
                                            {{$voucher->half_payment ? "checked": ""}}>
                                            <label class="form-check-label" for="half-payment">
                                              Half Payament
                                            </label>
                                        </div>
                                        <div class="form-group w-100 mb-2 d-flex align-items-center">
                                            <label for="" class="form-label me-3">Paymaent</label>
                                            <select name="payment" id="payment" class="form-select form-select-sm mb-1" required>
                                                <option value="cash" 
                                                {{$voucher->payment == 'cash' ? "selected": ""}}>
                                                    Cash
                                                </option>
                                                <option value="banking" 
                                                {{$voucher->payment == 'banking' ? "selected": ""}}>
                                                    Online Banking
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group w-100 mb-2 d-flex align-items-center">
                                            <label for="" class="form-label me-3">Total </label>
                                            <input type="number" class="form-control form-control-sm" disabled id="total-amount">
                                        </div>
                                        <div class="form-group w-100 mb-2 d-flex align-items-center">
                                            <label for="" class="form-label me-3">Paid </label>
                                            <input type="number" class="form-control form-control-sm" id="voucher-paid">
                                        </div>
                                        <div class="form-group w-100 mb-2 d-flex align-items-center">
                                            <label for="" class="form-label me-3">Discount </label>
                                            <input type="number" class="form-control form-control-sm" id="voucher-discount" value="0" step="0.1" onkeyup="voucherDiscount()">
                                        </div>
                                        <div class="form-group d-flex justify-content-between row">
                                            <button class="btn btn-secondary col-4" style="height: 80px;" onclick="voucherSave()">Update</button>
                                            <!-- <button class="btn btn-secondary col-7" style="height: 80px;">print</button> -->
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
@endsection

@section('script')
<script src="{{asset('js/voucher_edit.js')}}"></script>
@endsection