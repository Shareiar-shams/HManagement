<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.home')}}" class="brand-link">
    	
      	<img src="{{asset('admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      	<span class="brand-text font-weight-light">{{config('app.name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
	    <!-- Sidebar user panel (optional) -->
	    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
	        <div class="image">
	        	@if(Auth::guard('admin')->user()->image != 'noimage.jpg')

		            <img src="{{Storage::disk('local')->url(Auth::guard('admin')->user()->image)}}"  class="img-circle elevation-2" alt="User Image">
		        @else
	          		<img src="{{asset('admin/dist/img/avatar4.png')}}" class="img-circle elevation-2" alt="User Image">
	          	@endif
	        </div>
	        <div class="info">
	          	<a href="{{route('admin.profile')}}" class="d-block">{{ Auth::guard('admin')->user()->name }}</a>
	        </div>
	    </div>

	    <!-- SidebarSearch Form -->
	    <div class="form-inline">
	        <div class="input-group" data-widget="sidebar-search">
	        	<x-text-input class="form-control form-control-navbar" type="search" name="search" placeholder="Search" aria-label="Search" required autofocus autocomplete="search" />

	          	<div class="input-group-append">
	          		<x-ad-nevigation-button class="btn btn-sidebar">
	                  	<i class="fas fa-search fa-fw"></i>
	                </x-ad-nevigation-button>
		        </div>
	        </div>
	    </div>

	    <!-- Sidebar Menu -->
	    <nav class="mt-2">
	        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
	          	<!-- Add icons to the links using the .nav-icon class
	               with font-awesome or any other icon font library -->

		        <li class="nav-item">
		        	<x-ad-nav-link href="{{route('admin.home')}}" class="nav-link {{ Route::currentRouteNamed( 'admin.home' ) ?  'active' : '' }}">
		              <i class="nav-icon fas fa-tachometer-alt"></i>
		              <p>
		                Dashboard
		              </p>
		            </x-ad-nav-link>
		        </li>
		        <li class="nav-item">
		            
		            <x-ad-nav-link class="nav-link">
		            	<i  class='fas fa-list-alt'></i>
		              	<p class="pl-2">
		                	Manage Categories
		                	<i class="fas fa-angle-left right"></i>
		              	</p>
		            </x-ad-nav-link>
		            <ul class="nav nav-treeview">
		              	<li class="nav-item">
		              		<a href="{{route('categories.index')}}" class="nav-link {{ Route::currentRouteNamed( 'categories.index' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Categories</p>
		                	</a>
		              	</li>
		            </ul>
		        </li>

		        <li class="nav-item">
		            <x-ad-nav-link class="nav-link">
		            	<i  class='fas fa-list-alt'></i>
		              	<p class="pl-2">
		                	Manage Floor
		                	<i class="fas fa-angle-left right"></i>
		              	</p>
		            </x-ad-nav-link>
		            <ul class="nav nav-treeview">
		              	<li class="nav-item">
		              		<a href="{{route('floor.index')}}" class="nav-link {{ Route::currentRouteNamed( 'floor.index' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Floor List</p>
		                	</a>

		                	<a href="{{route('floor.create')}}" class="nav-link {{ Route::currentRouteNamed( 'floor.create' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Create Floor</p>
		                	</a>
		              	</li>
		            </ul>
		        </li>

		        <li class="nav-item">
		            <x-ad-nav-link class="nav-link">
		            	<i  class='fab fa-product-hunt'></i>
		              	<p class="pl-2">
		                	Manage Room
		                	<i class="fas fa-angle-left right"></i>
		              	</p>
		            </x-ad-nav-link>
		            <ul class="nav nav-treeview">
		              	<li class="nav-item">
		              		<a href="{{route('item.add')}}" class="nav-link {{ Route::currentRouteNamed( 'item.add' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Add Room</p>
		                	</a>
		              	</li>

		              	<li class="nav-item">
		              		<a href="{{route('item.index')}}" class="nav-link {{ Route::currentRouteNamed( 'item.index' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>All Rooms</p>
		                	</a>
		              	</li>
		            
		            </ul>
		        </li>

		        <li class="nav-item">
		            <x-ad-nav-link class="nav-link">
		            	<i  class='fab fa-first-order'></i>
		              	<p class="pl-2">
		                	Manage Booking 
		                	<i class="fas fa-angle-left right"></i>
		              	</p>
		            </x-ad-nav-link>
		            <ul class="nav nav-treeview">
		              	<li class="nav-item">
		              		<a href="{{route('booking.index')}}" class="nav-link {{ Route::currentRouteNamed( 'booking.index' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>All Booking Room</p>
		                	</a>
		              	</li>

		              	<li class="nav-item">
		              		<a href="{{route('booking.type', ['type' => 'Pending'])}}" class="nav-link {{ Route::currentRouteNamed( 'booking.type', ['type' => 'Pending'] ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Pending Room</p>
		                	</a>
		              	</li>

		              	<li class="nav-item">
		              		<a href="{{route('booking.type', ['type' => 'Booked'])}}" class="nav-link {{ Route::currentRouteNamed( 'booking.type', ['type' => 'Booked'] ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Booking Room</p>
		                	</a>
		              	</li>

		              	<li class="nav-item">
		              		<a href="{{route('booking.type', ['type' => 'Checkout'])}}" class="nav-link {{ Route::currentRouteNamed( 'booking.type', ['type' => 'Checkout'] ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Checkout Room</p>
		                	</a>
		              	</li>

		              	<li class="nav-item">
		              		<a href="{{route('booking.type', ['type' => 'Canceled'])}}" class="nav-link {{ Route::currentRouteNamed( 'booking.type', ['type' => 'Canceled'] ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Canceled Room</p>
		                	</a>
		              	</li>

		              	<li class="nav-item">
		              		<a href="{{route('restaurant.index')}}" class="nav-link {{ Route::currentRouteNamed( 'restaurant.index' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Restaurent Booked</p>
		                	</a>
		              	</li>

		              	
		            </ul>
		        </li>
		       

		        <li class="nav-item">
		        	<x-ad-nav-link href="{{route('transections.index')}}" class="nav-link {{ Route::currentRouteNamed( 'transections.index' ) ?  'active' : '' }}">
		              
		              <i class="nav-icon fas fa-random"></i>
		              <p>
		                Transactions
		              </p>
		            </x-ad-nav-link>
		        </li>


		        <li class="nav-item">
		        	<x-ad-nav-link href="{{route('customers.list')}}" class="nav-link {{ Route::currentRouteNamed( 'customers.list' ) ?  'active' : '' }}">
		              
		              <i class="nav-icon fas fa-users"></i>
		              <p>
		                Customers List
		              </p>
		            </x-ad-nav-link>
		        </li>

		        


		        <li class="nav-item">
		            <a href="#" class="nav-link">
			            <i class="nav-icon fas fa-user"></i>
			            
			            <p>
			                System User
			                <i class="fas fa-angle-left right"></i>
			            </p>
		            </a>
		            <ul class="nav nav-treeview">
		            	<li class="nav-item">
		              		<a href="{{route('permissions.index')}}" class="nav-link {{ Route::currentRouteNamed( 'permissions.index' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Permission</p>
		                	</a>
		              	</li>
			            <li class="nav-item">
		              		<a href="{{route('roles.index')}}" class="nav-link {{ Route::currentRouteNamed( 'roles.index' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>Role</p>
		                	</a>
		              	</li>
			            <li class="nav-item">
		              		<a href="{{route('admins.index')}}" class="nav-link {{ Route::currentRouteNamed( 'admins.index' ) ?  'active' : '' }}">
		                	
		                  		<i class="far fa-circle nav-icon"></i>
		                  		<p>System User</p>
		                	</a>
		              	</li>
		            </ul>
		        </li>


	        </ul>
	    </nav>
	    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
