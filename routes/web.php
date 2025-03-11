<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use App\Http\Middleware\RedirectIfNotAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



/*
|--------------------------------------------------------------------------
| Viewport Routes
|--------------------------------------------------------------------------
*/

Route::group(['namespace'=> 'App\Http\Controllers\User'],function(){
    Route::get('/', 'HomeController@index')->name('main');


    Route::get('/rooms', 'HomeController@rooms')->name('rooms');

    Route::post('searchRoom', 'HomeController@searchRoom')->name('searchRoom');

    Route::get('/roomResults', 'HomeController@hotelResults')->name('hotelResults');

    // Route::get('/roomDetails/{slug}', 'HomeController@getroomDetails');
    Route::get('/roomDetails/{slug}', 'HomeController@roomDetails')->name('roomDetails');

    // Route::get('/reservation', 'HomeController@getroomDetails');
    Route::get('/reservation', 'HomeController@create')->middleware(['auth', 'verified'])->name('reservation');
    
    Route::post('/payment', 'HomeController@store')->name('payment');

    Route::post('/sslcommerz/initiate', 'HomeController@initiate')->name('initiate');
    Route::post('/sslcommerz/success', 'HomeController@paymentSuccess')->name('sslcommerz.success');
    Route::post('/sslcommerz/fail', 'HomeController@paymentFail')->name('sslcommerz.fail');
    Route::post('/sslcommerz/cancel', 'HomeController@paymentCancel')->name('sslcommerz.cancel');

    Route::get('/restaurent/bookings', 'HomeController@restaurent')->middleware(['auth', 'verified'])->name('restaurent');
    Route::post('/restaurent/bookings', 'HomeController@restaurent_booking')->name('restaurent_booking');

    Route::get('/dashboard', 'HomeController@dashboard')->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/dashboard/reserve/restaurent', 'HomeController@userReserveRestaurent')->middleware(['auth', 'verified'])->name('userReserveRestaurent');
    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group(['namespace'=> 'App\Http\Controllers\Admin'],function(){

    Route::get('/admin/login', 'Auth\AuthenticatedSessionController@create')->name('admin.login');
    Route::post('/admin/login', 'Auth\AuthenticatedSessionController@authenticate')->name('admin.login.post');
    Route::post('/admin/logout', 'Auth\AuthenticatedSessionController@destroy')->name('admin.logout');
    //Admin Home page after login
    Route::middleware(RedirectIfNotAdmin::class)->group(function () {
        Route::get('/admin/home', 'HomeController@index')->name('admin.home');
        Route::get('/admin/profile', 'HomeController@profile')->name('admin.profile');

        // Admin Profile
        Route::post('/admin/image/update/{id}', 'HomeController@imgupdate')->name('admin.image.update');
        Route::put('/admin/password/update/{id}', 'HomeController@passupdate')->name('admin.password.update');
        Route::put('/admin/profile/update/{id}', 'HomeController@update')->name('admin.profile.update');

        Route::delete('/admin/email/delete/{id}', 'HomeController@mail_destroy')->name('email.delete');
        Route::post('/admin/email/delete/{slug}/all', 'HomeController@deleteAll')->name('email.alldelete');

        //website Customer List Route
        Route::get('/admin/customers/list/', 'HomeController@create')->name('customers.list');
        Route::put('/admin/user/profile/status/{id}', 'HomeController@status')->name('user.profile.status');
        Route::get('/admin/user/profile/show/{id}', 'HomeController@show')->name('user.profile.show');
        Route::get('/admin/user/mlmuser/{id}', 'HomeController@check')->name('user.mlmuser.check');

        // Order route
        Route::resource('/admin/booking','OrdersController');
        Route::put('/admin/booking/payment/status/{id}', 'OrdersController@payment_status')->name('booking.payment_status');
        Route::post('/admin/booking/payment/orderStatus/{id}', 'OrdersController@orderStatus')->name('booking.orderStatus');
        Route::get('/admin/booking/type/{type}', 'OrdersController@order_type')->name('booking.type');
        
        Route::get('/admin/charts/data', 'OrdersController@getChartData')->name('booking.chart.data');

        Route::get('/admin/order/status/{id}/order_status/{type}', 'OrdersController@type_status')->name('booking.type_status');
        Route::get('/admin/order/invoice/print/{id}', 'OrdersController@print_invoice')->name('booking.print_invoice');

        // transactions route
        Route::resource('/admin/transections','TransectionsController');

        //main route
        Route::resource('/admin/homecontroller','HomeController');

        //Contact Route
        Route::resource('/admin/contact/dyContact', 'ContactController');

        //Restaurent
        Route::resource('restaurant', 'RestaurentController');

        //Product Categories Route
        Route::resource('admin/room/categories','ProductCategoryController');

        //Product Type Route
        Route::resource('admin/room/item/type','ProductTypeController');
        Route::put('admin/room/item/status/{id}','ProductTypeController@status')->name('type.status');
        
        //Product Route
        Route::resource('admin/room/item','ProductController');
        Route::get('admin/room/add', 'ProductController@add')->name('item.add');
        Route::get('admin/room/item/create', 'ProductController@create')->name('physical.product.create');
    
        Route::put('admin/room/status/{id}','ProductController@change_status')->name('item.status');

        Route::post('img_dlt', 'ProductController@img_dlt')->name('img_dlt');
        
        

        // Product Import And Export Route
        Route::get('/admin/product/export', 'ProductController@export')->name('product.export');
        Route::post('/admin/product/import', 'ProductController@import')->name('product.import');
        Route::get('/admin/bulk/product/index', 'ProductController@imexport')->name('product.import.export');

        Route::resource('roles', 'RoleController');
        Route::resource('admins', 'AdminController');
        Route::resource('permissions', 'PermissionController');

    });
});

require __DIR__.'/auth.php';
