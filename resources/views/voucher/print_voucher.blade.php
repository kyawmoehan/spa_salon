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
        <b>Voucher ID: <span class="font-weight-bold" id="voucher-number"></span></b><br>
        <br>
        <b>Customer:</b> <span id="customer"></span><br>
        <b>Voucher Date:</b> <span class="date"></span><br>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row" id="item-row">
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
          <tbody id="items-table">

          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Table row -->
    <div class="row" id="service-row">
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
          <tbody id="service-table">
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
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
              <td><span id="total"></span> Ks</td>
            </tr>
            <tr>
              <th>Discount:</th>
              <td ><span id="discount"></span> %</td>
            </tr>
            <tr>
              <th>Total:</th>
              <td><span id="paid"></span> Ks</td>
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
  function addData(){
    let getVoucherStr = localStorage.getItem("printvoucher");
    let getVoucherArray = JSON.parse(getVoucherStr);
    console.log(getVoucherArray);
    $('.date').html(getVoucherArray['date']);
    $('#voucher-number').html(getVoucherArray['id']);
    $('#customer').html(getVoucherArray['customerName']);
    $('#total').html(getVoucherArray['total']);
    $('#discount').html(getVoucherArray['discount']);
    $('#paid').html(getVoucherArray['paid']);

    if(!getVoucherArray.hasOwnProperty('items') || getVoucherArray['items'].length == 0){
        $('#item-row').addClass('d-none');
    }
      $( "#items-table" ).empty();
      $.each( getVoucherArray['items'], function( i, item ) { 
          var newListItem = `
          <tr>
          <td class="text-dark"><b>${i+1}</b></td>
          <td>
              ${item['itemName']}
          </td>
          <td>
              ${item['quantity']}
          </td>
          <td>
              ${item['itemPrice']} Ks
          </td>
          <td>
              ${item['itemPrice']* item['quantity']} Ks
          </td>
        </tr>
          `; 
          $( "#items-table" ).append( newListItem ); 
      });

      if(!getVoucherArray.hasOwnProperty('services') || getVoucherArray['services'].length == 0){
        $('#service-row').addClass('d-none');
      }
      let servicesArray = [];
      $( "#service-table" ).empty();
      $.each( getVoucherArray['services'], function( i, item ) {   
        if(servicesArray.includes(item['serviceName'])){
            return;
        }else{
            servicesArray.push(item['serviceName']);
        }     
        var newListItem = `
        <tr>
        <td class="text-dark"><b>${i+1}</b></td>
        <td>
            ${item['serviceName']}
        </td>
        <td>
            ${1}
        </td>
        <td>
            ${item['servicePrice']} Ks
        </td>
        <td>
          ${item['servicePrice']} Ks
        </td>
    </tr>
        `; 
        $( "#service-table" ).append( newListItem );
     
    });

  }
  window.addEventListener("load", function(){
    addData();
    window.print();
  });
  window.onafterprint = function(){
    localStorage.removeItem('printvoucher');
    window.location.replace("/voucher/create");
  }

</script>
</body>
</html>
