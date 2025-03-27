<?php

use App\Http\Controllers\User\HomeController;

Route::post('/sslcommerz/success', [HomeController::class, 'success']);
Route::post('/sslcommerz/fail', [HomeController::class, 'fail']);
Route::post('/sslcommerz/cancel', [HomeController::class, 'cancel']);