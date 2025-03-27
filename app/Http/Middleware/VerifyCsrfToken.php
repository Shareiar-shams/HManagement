<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'sslcommerz/success', // Ensure success callback is not blocked
        'sslcommerz/fail', // Exclude fail route if needed
        'sslcommerz/cancel' // Exclude cancel route
    ];
}
