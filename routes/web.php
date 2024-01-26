<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return json_encode([
        'app_name' => env('APP_NAME'),
        'app_url'  => env("APP_URL"),
        'app_env'  => env("APP_ENV"),
        'time'     => time(),
        'date'     => date('Y-m-d H:i:s'),
        'routes'   => array_map(function (\Illuminate\Routing\Route $route) {
            return $route->uri;
        }, (array) Route::getRoutes()->getIterator())
    ]);
});

