<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembeliController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PembayaranController;
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

// default route
Route::get('/', function () {
    return view('auth.login');
});
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    // beranda route
    Route::get('/beranda', [BerandaController::class, 'index']);

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

    //transaksi route
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::post('transaksi/update_stok', [TransaksiController::class, 'update_stok']);
    Route::post('transaksi/save', [TransaksiController::class, 'save']);
    Route::delete('transaksi/delete/{id}', [TransaksiController::class, 'delete']);
    Route::get('transaksi/cetak/{id}', [TransaksiController::class, 'cetak_pdf']);

    //pembayaran route
    Route::get('/pembayaran', [PembayaranController::class, 'index']);
    Route::get('/pembayaran/detail_bayar/{id}', [PembayaranController::class, 'detail_bayar']);
    Route::post('pembayaran/save', [PembayaranController::class, 'save']);
    Route::delete('pembayaran/delete/{id}', [PembayaranController::class, 'delete']);
});