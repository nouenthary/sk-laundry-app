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

Route::get('/auth',[App\Http\Controllers\LoginController::class,'index']);
Route::post('/auth/login',[App\Http\Controllers\LoginController::class,'login']);

Route::get('/',[App\Http\Controllers\HomeController::class,'index']);

Route::resource('admin/agents',App\Http\Controllers\AgentController::class);
Route::get('admin/getAgent',[App\Http\Controllers\AgentController::class,'getAgent'])->name('get-agent');

//Route::get('{any}', function () {
//    return view('welcome');
//})->where('any', '.*');

 Route::get('/auth/welcome', function () {
     return view('welcome');
 });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
