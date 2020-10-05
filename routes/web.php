<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SuratJalanController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    //return Inertia\Inertia::render('Dashboard');
    return view('layouts.blank');
})->name('dashboard');

Route::middleware('auth')->group(function(){
    Route::resource('product', ProductController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('purchase', PurchaseOrderController::class);
    Route::resource('purchase/{purchase}/sj', SuratJalanController::class);
});
