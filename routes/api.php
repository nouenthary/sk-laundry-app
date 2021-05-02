<?php

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [UserController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {
    // user
    Route::post('register', [UserController::class, 'register']);

    //test
    Route::get('details', [UserController::class, 'details']);

    // service type
    Route::get('service-type', [ServiceController::class, 'GetServiceType']);

    // order
    Route::apiResource('orders', App\Http\Controllers\OrderController::class);

    // product
    Route::apiResource('products', App\Http\Controllers\ProductController::class);

    // agent
    Route::apiResource('agents', App\Http\Controllers\AgentController::class);

    // service
    Route::apiResource('services', App\Http\Controllers\ServiceController::class);

    // customers
    Route::apiResource('customers', App\Http\Controllers\CustomerController::class);

    // invoice
    Route::apiResource('invoice', App\Http\Controllers\InvoiceController::class);

    // Reports
    Route::apiResource('OrderReports', App\Http\Controllers\OrderReportController::class);

});

Route::middleware('api')->group(function () {

});

