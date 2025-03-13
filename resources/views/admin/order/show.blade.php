@extends('admin.layouts.layout')
@section('admin_title_content')
    HManagement | Invoice
@endsection
@section('admin_css_content')
  

@endsection
@section('admin_content_header')
	<div class="col-sm-6">
		<h1 class="m-0">Invoice</h1>
	</div><!-- /.col -->
	@php 
	  $list = json_encode(['Home', 'Invoice']);
	@endphp
	<x-ad-breadcrumb :list="$list"/>
@endsection

@section('admin_main_content')
	<div class="container-fluid">
		  <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                      <i class="fas fa-globe"></i> {{$order->name}}.
                      <small class="float-right">Date: {{ $order->created_at->format('m/d/Y') }}</small>
                  </h4>
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
                            <td>{{$order->days}}</td>
                            <td>{{$order->adult_members}}</td>
                            <td>{{$order->children_members}}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <br>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                  <div class="col-12">
                      <a href="{{route('booking.print_invoice',$order->id)}}" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                      {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                        Payment
                      </button> --}}
                      <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                        <i class="fas fa-download"></i> Generate PDF
                      </button>
                  </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
      </div><!-- /.row -->
	</div>
@endsection

@section('admin_js_content')

@endsection
