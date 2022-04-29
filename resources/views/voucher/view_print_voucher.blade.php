<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Voucher Print</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- <link rel="stylesheet" href="assets/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style type="text/css">
    @media print {
    @page { margin: 0; }
    body { margin: 1.6cm; }
  }
  </style>
</head>
<body>
<div class="container-fluid wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="d-flex justify-content-between">
        <h2 class="page-header">
          SPA
        </h2>
        <small class="float-right">Print Date: 
            <?php echo (new DateTime())->format('Y-m-d'); ?>
          </small>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        <b>Voucher ID: {{$voucher->voucher_number}}</b><br>
        <br>
        <b>Customer:</b> {{$voucher->customer->name}}<br>
        <b>Voucher Date:</b> {{$voucher->date}}<br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    @if(count($voucher->voucherItems) != 0)
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
          </tr>
          </thead>
          <tbody>
            @foreach($voucher->voucherItems as $key=>$item)
            <tr>
                <th>{{$key+1}}</th>
                <td>{{$item->item->name}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->item_price}}</td>
                <td>{{$item->item_price*$item->quantity}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    @endif
    <!-- /.row -->
    <!-- Table row -->
    @if(count($voucher->voucherStaff) != 0)
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>No</th>
            <th>Service Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
          </tr>
          </thead>
          <tbody>
            @php
                $servicesArray = [];
            @endphp
            @foreach($voucher->voucherStaff as $key=>$staff)
                @if(in_array($staff->service->name, $servicesArray))
                    @continue;
                @else
                    @php
                    array_push($servicesArray, $staff->service->name);
                    @endphp
                @endif
            <tr>
                <th>{{$key+1}}</th>
                <td>{{$staff->service->name}}</td>
                <td>{{1}}</td>
                <td>{{$staff->service->price}}</td>
                <td>{{$staff->service->price}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    @endif
    <!-- /.row -->
    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
      </div>
      <!-- /.col -->
      <div class="col-6">
        <!-- <p class="lead">Amount Due 2/22/2014</p> -->

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td>{{$voucher->total}} Ks</td>
            </tr>
            <tr>
              <th>Discount:</th>
              <td>{{$voucher->discount}} %</td>
            </tr>
            <tr>
              <th>Total:</th>
              <td>{{$voucher->paid}}</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- /.row -->
    <div class="row">
      <!-- /.col -->
      <div class="col-12">
        <p class="display-4"><center>Thank you.</center></p>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<script src="{{asset('assets/js/vendor/jquery-2.2.4.min.js')}}"></script>
<script type="text/javascript"> 
  window.addEventListener("load", function(){
    window.print();
  });
  window.onafterprint = function(){
    history.back();
  }
</script>
</body>
</html>
