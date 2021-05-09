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

Route::get('/auth',[App\Http\Controllers\LoginController::class,'index'])->name('auth-login');
Route::post('/auth/login',[App\Http\Controllers\LoginController::class,'login']);

Route::resource('admin/agents',App\Http\Controllers\AgentController::class);
Route::get('admin/getAgent',[App\Http\Controllers\AgentController::class,'getAgent'])->name('get-agent');


//orders
Route::resource('orders',App\Http\Controllers\OrdersController::class);
Route::get('orders/order_id/{order_id}',[App\Http\Controllers\OrdersController::class,'add']);

Route::post('product-by-category',[App\Http\Controllers\ProductController::class,'getProductByCategory']);


//Route::get('{any}', function () {
//    return view('welcome');
//})->where('any', '.*');

// Route::get('/auth/welcome', function () {
//     return view('welcome');
// });

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
