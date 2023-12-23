<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get_city_by_ip', function() {
    $ip = $_SERVER['REMOTE_ADDR'];
    // dd($ip);
    $data = Location::get("91.201.74.74"); // 8.8.8.8     5.136.0.6     77.88.55.242   91.201.74.74
    dd($data);
    return '{"city":"Novosibirsk","country":"Russia","ip":'.$ip.'}';
});