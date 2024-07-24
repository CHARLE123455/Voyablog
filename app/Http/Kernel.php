<?php
namespace App\Http;

use App\Http\Middleware\TokenAuthMiddleware;
use App\Http\Middleware\TokenMiddleware;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    
    protected $routeMiddleware = [

        'token' => TokenMiddleware ::class
    ];

}



