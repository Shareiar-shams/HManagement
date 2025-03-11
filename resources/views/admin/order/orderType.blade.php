@extends('admin.layouts.layout')
@section('admin_title_content')
    HManagement | Orders
@endsection
@section('admin_css_content')
  	<!-- DataTables -->
  	<link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  	<link rel="stylesheet" href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  	<link rel="stylesheet" href="{{asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  	<!-- daterange picker -->
	<link rel="stylesheet" href="{{asset('admin/plugins/daterangepicker/daterangepicker.css')}}">

	<!-- Tempusdominus Bootstrap 4 -->
	<link rel="stylesheet" href="{{asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">

	
@endsection
@section('admin_content_header')
	<div class="col-sm-6">
		<h1 class="m-0">Booking</h1>
	</div><!-- /.col -->
	@php 
	  $list = json_encode(['Home', 'Booking']);
	@endphp
	<x-ad-breadcrumb :list="$list"/>
@endsection

@section('admin_main_content')

	
	@if ($errors->any())                 
		@foreach ($errors->all() as $error)
			<div class="alert alert-danger alert-block">
		        <a type="button" class="close" data-dismiss="alert"></a> 
		        <strong>{{ $error }}</strong>
		    </div>
		@endforeach						                   
	@endif
	<div class="container-fluid">
		<form action="{{route('booking.type', $type)}}" method="GET">
			@csrf
			@method('get')
	        <div class="row mb-4 justify-content-center">
	            <div class="col-md-6 col-sm-6 col-lg-4">
	            	<div class="form-group">
	                  	<label>Start Date *</label>
	                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
	                        <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#reservationdate" placeholder="Start Date" value="" />
	                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
	                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-6 col-sm-6 col-lg-4">
	            	<div class="form-group">
	                  	<label>End Date *</label>
	                    <div class="input-group date" id="reservationdate2" data-target-input="nearest">
	                        <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#reservationdate2" placeholder="End Date" value="" />
	                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
	                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-lg-12 text-center mt-3">
	                <button type="submit" class="btn btn-success py-1 mr-2">Filter</button>
	                <button type="reset" class="btn btn-info py-1">Reset</button>
	            </div>
	        </div>
	    </form>
      	<div class="row">
        	<div class="col-12">
          	

	          	<div class="card">
	              	<div class="card-header">
	                	<h3 class="card-title">Booking</h3>
	              	</div>
		            <!-- /.card-header -->
		            <div class="card-body">
		                <table id="example1" class="table table-bordered table-striped">
		                  	<thead>
				                <tr>
				                	<th></th>
				                	<th>Transaction Id</th>
				                    <th>User Name</th>
				                    <th>Room Name</th>
				                    <th>Room Floor</th>
				                    <th>Checking In</th>
				                    <th>Checking Out</th>
				                    <th>Total Amount</th>
				                    <th>Payment Id</th>
				                    <th>Payment Status</th>
				                    <th>Order Status</th>
				                    <th>Payment Gateway</th>
				                    <th>Action</th>
				                </tr>
		                  	</thead>
		                  	<tbody>
		                  		@forelse($orders as $order)
					                <tr>
					                	<td> {{$loop->index+1}}</td>
				                    	<td>{{$order->tran_id}}</td>
				                    	<td>{{$order->name}}</td>
				                    	<td>{{$order->room_name}}</td>
				                    	<td>{{$order->product->type->name}}</td>
				                    	<td>{{$order->checkinDate}}</td>
				                    	<td>{{$order->checkoutDate}}</td>
				                    	<td>{{$order->total}}</td>
				                    	<td>{{$order->transactions->paymentId ?? 'No Payment ID'}}</td>
				                    	
				                    	<td>
			                    			<div class="btn-group">
							                    <button type="button" @if($order->payment_status == 'Paid') class="btn btn-success dropdown-toggle" @else class="btn btn-danger dropdown-toggle" @endif data-toggle="dropdown">@if($order->payment_status == 'Paid') Paid @else Unpaid @endif 
							                    	<span class="sr-only">Toggle Dropdown</span>
							                    </button>
							                    <div class="dropdown-menu" role="menu">
								                    <form action="{{route('booking.payment_status',$order->id)}}" method="post" id="disable-form-{{$order->id}}" style="display: none;">
			                              				@csrf
			                              				@method('put')
			                              				<input type="hidden" name="payment_status" value="@if($order->payment_status == 'Paid') Unpaid @else Paid @endif">
					                            	</form>
							                      	<a class="dropdown-item" href="#" onclick="
							                            if(confirm('Want to change this order payment status!'))
							                            {
							                                event.preventDefault();
							                                document.getElementById('disable-form-{{$order->id}}').submit();
							                            }
							                            else
							                            {
							                                event.preventDefault();
							                            }
							                        ">@if($order->payment_status == 'Paid') Unpaid @else Paid @endif</a>
							                    </div>
						                	</div>
				                    	</td>
				                    	
				                    	<td>
						                	<div class="btn btn-info dropdown">
									            <button class="btn {{ $order->order_status }}  btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									              	{{$order->order_status}}
									            </button>
									            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
										            <a class="dropdown-item update-status-link" href="{route('booking.type_status',['id' => $order->id, 'type' => 'Pending'])}}">Pending Room</a>
													<a class="dropdown-item update-status-link" href="{{route('booking.type_status',['id' => $order->id, 'type' => 'Booked'])}}">Booked Room</a>
													<a class="dropdown-item update-status-link" href="{{route('booking.type_status',['id' => $order->id, 'type' => 'Checkout'])}}">Checkout Room</a>
													<a class="dropdown-item update-status-link"  href="{{route('booking.type_status',['id' => $order->id, 'type' => 'Canceled'])}}">Canceled Room</a>

									            </div>
									        </div>
				                    	</td>
				                    	<td>
				                    		{{$order->transactions->gateway_type}}
				                    	</td>
				                    	<td>
				                    		<div class="btn-group">
							                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Options
							                      	<span class="sr-only">Toggle Dropdown</span>
							                    </button>
							                    <div class="dropdown-menu" role="menu">
							                    	<a class="dropdown-item" href="{{route('booking.show',$order->id)}}"><i class="fas fa-angle-double-right"></i>View Order</a>
							                    		
							                      	<a class="dropdown-item" href="#" onclick="

				                            			if(confirm('Are you Want to Uproot this!'))

							                            {

							                                event.preventDefault();

							                                document.getElementById('delete-form-{{$order->id}}').submit();

							                            }

							                            else

							                            {

							                                event.preventDefault();

							                            }
								                        "><i class="fas fa-angle-double-right"></i>
								                    	{{ __('Delete') }}
								                    </a>
								                    <form action="{{route('booking.destroy',$order->id)}}" method="post" id="delete-form-{{$order->id}}" style="display: none;">
								                      	@csrf
														@method('delete')
							                        </form>
							                    </div>
							               	</div>
				                    	</td>
					                </tr>
				                @empty
				                	
				                @endforelse
		                  	</tbody>
		                </table>
		            </div>
		            <!-- /.card-body -->
	          	</div>
	          	<!-- /.card -->
        	</div>
        	<!-- /.col -->
      	</div>
      	<!-- /.row -->

      	<div class="modal fade show" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalModalLabel">
		    <div class="modal-dialog" role="document">
			    <div class="modal-content">

					<!-- Modal Header -->
			        <div class="modal-header">
			          	<h5 class="modal-title" id="exampleModalLabel">Update Status?</h5>
			          	<button class="close" type="button" data-dismiss="modal" aria-label="Close">
			            	<span aria-hidden="true">×</span>
			          	</button>
					</div>

					<!-- Modal Body -->
			        <div class="modal-body" id="model-body">
						You are going to update the status. Do you want proceed?
					</div>

					<!-- Modal footer -->
			        <div class="modal-footer">
			            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			            <a href="" id="link" class="btn btn-ok btn-success">Update</a>
					</div>

			    </div>
		    </div>
		</div>
  	</div>
  <!-- /.container-fluid -->
@endsection

@section('admin_js_content')

	<!-- InputMask -->
	<script src="{{asset('admin/plugins/moment/moment.min.js')}}"></script>
	<!-- date-range-picker -->
	<script src="{{asset('admin/plugins/daterangepicker/daterangepicker.js')}}"></script>

	<!-- Tempusdominus Bootstrap 4 -->
	<script src="{{asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>


	<script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
	<script src="{{asset('admin/plugins/jszip/jszip.min.js')}}"></script>
	<script src="{{asset('admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
	<script src="{{asset('admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
	<script src="{{asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
	<!-- page specific script -->
	<script>

		// document.addEventListener('DOMContentLoaded', () => {
		//     const updateStatusLinks = document.querySelectorAll('.update-status-link');

		//     updateStatusLinks.forEach(link => {
		//         link.addEventListener('click', function(event) {
		//             event.preventDefault();

		//             const modalUpdateLink = document.querySelector('#link');
		            

		//             if (modalUpdateLink) {
		//                 modalUpdateLink.href = this.dataset.href;
		//             }

		//             const modalBody = document.querySelector('#model-body');
		//             if (modalBody) {
		//                 modalBody.textContent = `Are you sure you want to update the order status to "${this.textContent}"?`;
		//             }
		//         });
		//     });
		// });

		document.addEventListener('DOMContentLoaded', function() {
		    const updateStatusLinks = document.querySelectorAll('.update-status-link');
		    const modalLink = document.getElementById('link');
		    const modalBody = document.getElementById('model-body');

		    updateStatusLinks.forEach(link => {
		        link.addEventListener('click', function(event) {
		            const href = this.getAttribute('data-href');
				    const statusText = this.textContent;

				    console.log('Clicked link:', this);
				    console.log('href:', href);
				    console.log('statusText:', statusText);
				    console.log('modalLink:', modalLink);
				    console.log('modalBody:', modalBody);

				    if (modalLink && modalBody) {
				        modalLink.href = href;
				        modalBody.textContent = `You are going to update the status to ${statusText.trim()}. Do you want to proceed?`;
				    }
		        });
		    });
		});

		//Date picker
	    $('#reservationdate').datetimepicker({
	        format: 'L'
	    });

	    //Date picker
	    $('#reservationdate2').datetimepicker({
	        format: 'L'
	    });

		$(function () {
		    $("#example1").DataTable({
		      	"responsive": true, "lengthChange": false, "autoWidth": false,
		      	"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
		    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		    
		});
	</script>
@endsection