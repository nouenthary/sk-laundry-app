<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[App\Http\Controllers\HomeController::class,'index']);
//
Route::get('signin',[App\Http\Controllers\LoginController::class,'index'])->name('auth-login');
Route::post('auth/login',[App\Http\Controllers\LoginController::class,'login']);
Route::get('logout',[App\Http\Controllers\LoginController::class,'logout']);

Route::group(['middleware' => ['auth']], function () {
    //orders
    Route::resource('orders',App\Http\Controllers\AgentOrderController::class);
    Route::get('orders/order_id/{order_id}',[App\Http\Controllers\AgentOrderController::class,'add']);
    Route::post('orders/set-agent-invoice',[App\Http\Controllers\AgentOrderController::class,'setaAgentToInvoice']);
    Route::post('agent/payment',[App\Http\Controllers\AgentOrderController::class,'payment']);
    Route::get('get-agent-orders',[App\Http\Controllers\AgentOrderController::class,'getAllAgentOrder']);

    // agents
    Route::resource('agents',App\Http\Controllers\AgentController::class);
    Route::get('admin/getAgent',[App\Http\Controllers\AgentController::class,'getAgent'])->name('get-agent');

    // service
    Route::resource('services',App\Http\Controllers\ServiceController::class);
    // products
    Route::resource('products',App\Http\Controllers\ProductController::class);

    // uplaod
    Route::post('uploads',[App\Http\Controllers\UploadController::class,'Upload']);
    
    // user prifole
    Route::get('change-profile', [App\Http\Controllers\LoginController::class,'changeProfile']);
    // udate password
    Route::post('update-password', [App\Http\Controllers\LoginController::class,'updatePassword']);
    // change image
    Route::post('change-photo',[App\Http\Controllers\LoginController::class,'changePhoto']);

    // customers
    Route::resource('customers',App\Http\Controllers\CustomerController::class);
    Route::get('get-customers', [App\Http\Controllers\CustomerController::class,'getCustomer']);

    // users
    Route::resource('users',App\Http\Controllers\UsersController::class);
});

// print
Route::get('print/{id}', [App\Http\Controllers\PrintController::class,'print']);

Route::post('product-by-category',[App\Http\Controllers\ProductController::class,'getProductByCategory']);



//Route::get('{any}', function () {
//    return view('welcome');
//})->where('any', '.*');

// Route::get('/auth/welcome', function () {
//     return view('welcome');
// });

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
