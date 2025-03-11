<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HManagement | Invoice</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
</head>
<body>
<div class="wrapper">
	  <!-- Main content -->
	  <section class="invoice">
  	    <!-- title row -->
  	    <div class="row">
  		    <div class="col-12">
  		        <h2 class="page-header">
  		          	<i class="fas fa-globe"></i> {{$order->name}}.
  	              	<small class="float-right">Date: {{ $order->created_at->format('m/d/Y') }}</small>
  		        </h2>
  		    </div>
  		    <!-- /.col -->
  	    </div>
	      <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            Billing Information
            <address>
              <strong>{{$order->name}}</strong><br>
              {{$order->address}}<br>
              {{$order->town}}, {{$order->postcode}}<br>
              Phone: {{$order->phone}}<br>
              Email: {{$order->email}}
            </address>
          </div>
          
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
           
            <b>Transaction ID:</b> {{$order->tran_id}}<br>
            <b>Payment Status:</b> {{$order->payment_status}}<br>
            <b>Payment Method:</b> {{$order->transactions->gateway_type}}<br>
            <b>Payment Id:</b> {{$order->transactions->paymentId ?? 'No Payment ID'}}
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

	      <!-- Table row -->
        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table table-striped">
              <thead>
              <tr>
                <th>Room Name</th>
                <th>Floor</th>
                <th>SKU #</th>
                <th>Total Cost</th>
                <th>Checkin Date</th>
                <th>Checkout Date</th>
                <th>Stay Day</th>
                <th>Adult Members</th>
                <th>Child Members</th>
              </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>{{$order->room_name}}</td>
                      <td>{{$order->product->type->name}}</td>
                      <td>{{$order->SKU}}</td>
                      <td>{{$order->total}}</td>
                    
                      <td>{{$order->checkinDate}}</td>
                      <td>{{$order->checkoutDate}}</td>
                      <td>{{$order->day}}</td>
                      <td>{{$order->adult_members}}</td>
                      <td>{{$order->children_members}}</td>
                  </tr>
              </tbody>
            </table>
          </div>
          <!-- /.col -->
        </div>
      	<!-- /.row -->

  	    <div class="row">
          <div class="col-12">
          
            <p class="lead">Order Status: {{$order->order_status}}</p>

            <div class="table-responsive">
                <table class="table">
                    <tr>
                      <th style="width:50%">Total:</th>
                      <td>{{$order->total}}</td>
                    </tr>
                </table>
            </div>
          </div>
          <!-- /.col -->
        </div>
	</section>
	<!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
