<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\BankController;
use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\Master\BarangController;
use App\Http\Controllers\Master\VendorController;
use App\Http\Controllers\TransaksiController;

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
    return view('home');
})->name('home');

// ======= MASTER ===========
Route::group(['prefix' => '/master', 'as' => 'master.'], function () {
    Route::group(['prefix' => '/bank', 'as' => 'bank.'], function () {
        Route::get('/', [BankController::class, 'index'])->name('index');
        Route::post('/store', [BankController::class, 'store'])->name('store');
        Route::put('/update/{id}', [BankController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [BankController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => '/kategori', 'as' => 'kategori.'], function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::post('/store', [KategoriController::class, 'store'])->name('store');
        Route::put('/update/{id}', [KategoriController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [KategoriController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => '/barang', 'as' => 'barang.'], function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::post('/store', [BarangController::class, 'store'])->name('store');
        Route::put('/update/{id}', [BarangController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [BarangController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => '/vendor', 'as' => 'vendor.'], function () {
        Route::get('/', [VendorController::class, 'index'])->name('index');
        Route::post('/store', [VendorController::class, 'store'])->name('store');
        Route::put('/update/{id}', [VendorController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [VendorController::class, 'destroy'])->name('destroy');
    });
});

Route::group(['prefix' => '/transaksi', 'as' => 'transaksi.'], function () {
    Route::get('/', [TransaksiController::class, 'index'])->name('index');
    Route::get('/create', [TransaksiController::class, 'create'])->name('create');
    Route::post('/store', [TransaksiController::class, 'store'])->name('store');
    Route::delete('/destroy/{id}', [TransaksiController::class, 'destroy'])->name('destroy');
    Route::get('/cek-limit/{id}', [TransaksiController::class, 'cekLimit'])->name('cekLimit');
});
