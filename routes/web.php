<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\SupplierController;
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

Route::get('/', [BerandaController::class, 'index']);

// barang route
Route::get('/barang', [BarangController::class, 'index']);
Route::get('barang/edit/{id}', [BarangController::class, 'edit']);
Route::post('barang/save', [BarangController::class, 'save']);
Route::delete('barang/delete/{id}', [BarangController::class, 'delete']);

// pembeli route
Route::get('/pembeli', [PembeliController::class, 'index']);
Route::get('pembeli/edit/{id}', [PembeliController::class, 'edit']);
Route::post('pembeli/save', [PembeliController::class, 'save']);
Route::delete('pembeli/delete/{id}', [PembeliController::class, 'delete']);

// supplier route
Route::get('/supplier', [SupplierController::class, 'index']);
Route::get('supplier/edit/{id}', [SupplierController::class, 'edit']);
Route::post('supplier/save', [SupplierController::class, 'save']);
Route::delete('supplier/delete/{id}', [SupplierController::class, 'delete']);