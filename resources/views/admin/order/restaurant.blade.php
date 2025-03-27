@extends('admin.layouts.layout')
@section('admin_title_content')
    HManagement | Restaurant
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
		<h1 class="m-0">Restaurant</h1>
	</div><!-- /.col -->
	@php 
	  $list = json_encode(['Home', 'Restaurant']);
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
		
      	<div class="row">
        	<div class="col-12">
	          	<div class="card">
	              	<div class="card-header">
	                	<h3 class="card-title">Restaurant Booking Data</h3>
	              	</div>
		            <!-- /.card-header -->
		            <div class="card-body">
		                <table id="example1" class="table table-bordered table-striped">
		                  	<thead>
				                <tr>
				                	<th></th>
				                	<th>User Name</th>
				                    <th>Name</th>
				                    <th>Email</th>
				                    <th>Phone</th>
				                    <th>Booking Date</th>
				                    <th>Booking Time</th>
				                    <th>Number of guests</th>
				                    <th>Action</th>
				                </tr>
		                  	</thead>
		                  	<tbody>
		                  		@forelse($restaurants as $restaurant)
		                  			@php
									    $bookingTime = Carbon\Carbon::parse($restaurant->booking_time);
									    $date = $bookingTime->format('d-m-Y');
									     // Extract Date (2025-03-13)
									    $time = $bookingTime->format('g.i A');  // Extract Time (3.00 PM format)
									@endphp
					                <tr>
					                	<td> {{$loop->index+1}}</td>
				                    	<td>{{$restaurant->user->name}}</td>
				                    	<td>{{$restaurant->name}}</td>
				                    	<td>{{$restaurant->email}}</td>
				                    	<td>{{$restaurant->Phone}}</td>
				                    	<td>{{$date}}</td>
				                    	<td>{{$time}}</td>
				                    	<td>{{$restaurant->number_of_guests}}</td>
				                    	
				                    	
				                    	<td>
				                    		<div class="btn-group">
							                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Options
							                      	<span class="sr-only">Toggle Dropdown</span>
							                    </button>
							                    <div class="dropdown-menu" role="menu">
							                    		
							                      	<a class="dropdown-item" href="#" onclick="

				                            			if(confirm('Are you Want to Uproot this!'))

							                            {

							                                event.preventDefault();

							                                document.getElementById('delete-form-{{$restaurant->id}}').submit();

							                            }

							                            else

							                            {

							                                event.preventDefault();

							                            }
								                        "><i class="fas fa-angle-double-right"></i>
								                    	{{ __('Delete') }}
								                    </a>
								                    <form action="{{route('restaurant.destroy',$restaurant->id)}}" method="post" id="delete-form-{{$restaurant->id}}" style="display: none;">
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