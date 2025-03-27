@extends('admin.layouts.layout')
@section('admin_title_content')
    HManagement | Room
@endsection
@section('admin_css_content')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
@endsection
@section('admin_content_header')
	<div class="col-sm-6">
		<h1 class="m-0">Room List</h1>
	</div><!-- /.col -->
	@php 
	  $list = json_encode(['Home', 'Product']);
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
	                	<h3 class="card-title">Room List</h3>
	                	<div style="float: right;">
		                	<a href="{{route('product.export')}}" class="btn btn-success" title="">CSV Export</a>
		                		<a href="{{route('item.add')}}" class="btn btn-primary" title="">Add Product</a>
	                	</div>

	              	</div>
		            <!-- /.card-header -->
		            <div class="card-body">
		            	
		                <table id="example1" class="table table-bordered table-striped">
		                  	<thead>
				                <tr>
				                    <th>No</th>
				                    <th>Image</th>
				                    <th>Name</th>
				                    <th>Price</th>
				                    <th>Status</th>
				                    <th>Floor</th>
				                    <th>Action</th>
				                </tr>
		                  	</thead>
		                  	<tbody>
	                  		@foreach($products as $data)
				                <tr>
			                    	<td>{{$loop->index + 1}}</td>
			                    	<td>
										@if (Str::startsWith($data->featured_image, 'https'))
											<img class="img-responsive" width="50" height="70" src="{{$data->featured_image}}" alt="Room Image {{$data->id}}">
										@else
											<img class="img-responsive" width="50" height="70" src="{{Storage::disk('local')->url($data->featured_image)}}" alt="Room Image {{$data->id}}">
										@endif
			                    	</td>
			                    	<td>{{$data->name}}</td>
			                    	<td>{{ isset($data->special_price) ? $data->special_price : $data->price}}</td>
			                    	
			                    	<td>
			                    		<div class="btn-group">
						                    <button type="button" @if($data->status == true) class="btn btn-success dropdown-toggle" @else class="btn btn-danger dropdown-toggle" @endif data-toggle="dropdown">@if($data->status == true) Publish @else Unpublish @endif 
						                    	<span class="sr-only">Toggle Dropdown</span>
						                    </button>
						                    <div class="dropdown-menu" role="menu">
						                    	<form action="{{route('item.status',$data->id)}}" method="post" id="disable-form-{{$data->id}}" style="display: none;">
			                              			@csrf
			                              			@method('put')
			                              			<input type="hidden" name="status" value="@if($data->status == true) 0 @else 1 @endif">
			                            		</form>
						                      	<a class="dropdown-item" href="#" onclick="
						                            if(confirm('Want to change this type status!'))
						                            {
						                                event.preventDefault();
						                                document.getElementById('disable-form-{{$data->id}}').submit();
						                            }
						                            else
						                            {
						                                event.preventDefault();
						                            }
						                        ">@if($data->status == true) Unpublish @else Publish @endif</a>
						                    </div>
						                </div>
			                    	</td>
			                    	<td><label class="badge badge-primary">{{str_replace('Product', '', $data->floor->name)}}</label></td>
			                    	<td>
			                    		<div class="btn-group">
						                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Options
						                      	<span class="sr-only">Toggle Dropdown</span>
						                    </button>
						                    <div class="dropdown-menu" role="menu">
						                    		
						                    	<a class="dropdown-item" href="{{route('item.edit',$data->id)}}"><i class="fas fa-angle-double-right"></i>Edit</a>
						                    		
						                    		
						                    		
						                      	<a class="dropdown-item" href="#" onclick="

			                            			if(confirm('Are you Want to Uproot this!'))

						                            {

						                                event.preventDefault();

						                                document.getElementById('delete-form-{{$data->id}}').submit();

						                            }

						                            else

						                            {

						                                event.preventDefault();

						                            }
						                        "><i class="fas fa-angle-double-right"></i>
							                    		{{ __('Delete') }}
												</a>
												<form action="{{route('item.destroy',$data->id)}}" method="post" id="delete-form-{{$data->id}}" style="display: none;">
													@csrf
													@method('delete')
												</form>
						                      	
						                    </div>
						                </div>
			                    	</td>
				                </tr>
				            @endforeach
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
	<!-- DataTables  & Plugins -->
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

	<!-- Select2 -->
	<script src="{{asset('admin/plugins/select2/js/select2.full.min.js')}}"></script>
	<!-- Page specific script -->
	<script>
		$(function () {
	      	$('.select2').select2()
	    });
		$(function () {

		    $("#example1").DataTable({
		      	"responsive": true, "lengthChange": false, "autoWidth": false,
		      	"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
		    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
		    
		});
	</script>
@endsection