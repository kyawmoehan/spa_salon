<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\GeneralCostController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\CounterItemController;
use App\Http\Controllers\UsageItemController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\VoucherStaffController;
use App\Http\Controllers\ItemVoucherController;

use Illuminate\Http\Request;

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
Route::resource('service', ServiceController::class, ["name" => "service"]);
Route::resource('purchase', PurchaseItemController::class, ["name" => "purchase"]);
Route::resource('counter', CounterItemController::class, ["name" => "counter"]);
Route::resource('usage', UsageItemController::class, ["name" => "usage"]);
Route::resource('voucher', VoucherController::class, ["name" => "voucher"]);
Route::resource('salary', SalaryController::class, ["name" => "salary"]);

Route::get('salelist', [ItemVoucherController::class, 'index'])->name('salelist');

// ajax route
Route::get('getitems', [itemController::class, 'getitems']);
Route::get('staffrecord', [VoucherStaffController::class, "getStaffRecord"]);

// excel export roue
Route::get('voucherexport', [VoucherController::class, 'export'])->name('voucherexport');
Route::get('generalcostexport', [GeneralCostController::class, 'export'])->name('generalcostexport');
Route::get('usageitemexport', [UsageItemController::class, 'export'])->name('usageitemexport');
Route::get('salaryexport', [SalaryController::class, 'export'])->name('salaryexport');
Route::get('saleexport', [ItemVoucherController::class, 'export'])->name('saleexport');

require __DIR__.'/auth.php';
