<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\GeneralCostController;

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

Route::get('/', [PageController::class, 'dashboard'])->name('home'); 

Route::resource('user', UserController::class, ["name" => "user"]);
Route::resource('staff', StaffController::class, ["name" => "staff"]);
Route::resource('customer', CustomerController::class, ["name" => "customer"]);
Route::resource('type', TypeController::class, ["name" => "type"]);
Route::resource('item', ItemController::class, ["name" => "item"]);
Route::resource('generalcost', GeneralCostController::class, ["name" => "generalcost"]);

require __DIR__.'/auth.php';
