<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Route;

// Halaman Beranda Publik
Route::get('/', [HomeController::class, 'indeks'])->name('beranda');

// Rute Otentikasi
Route::get('/masuk', [AuthController::class, 'tampilMasuk'])->name('masuk');
Route::post('/masuk', [AuthController::class, 'prosesMasuk'])->name('masuk.proses');
Route::post('/keluar', [AuthController::class, 'keluar'])->name('keluar');

// Rute Khusus Admin (Guard: admin)
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dasbor', [AdminController::class, 'dasbor'])->name('dasbor');
    Route::post('/identitas', [AdminController::class, 'perbaruiIdentitas'])->name('identitas.perbarui');
    Route::post('/operator', [AdminController::class, 'simpanOperator'])->name('operator.simpan');
    Route::delete('/operator/{id}', [AdminController::class, 'hapusOperator'])->name('operator.hapus');
});

// Rute Khusus Operator (Guard: operator)
Route::middleware('auth:operator')->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dasbor', [OperatorController::class, 'dasbor'])->name('dasbor');
    Route::post('/lokasi', [OperatorController::class, 'simpanLokasi'])->name('lokasi.simpan');
    Route::delete('/lokasi/{id}', [OperatorController::class, 'hapusLokasi'])->name('lokasi.hapus');
    Route::post('/proyek', [OperatorController::class, 'simpanProyek'])->name('proyek.simpan');
    Route::delete('/proyek/{id}', [OperatorController::class, 'hapusProyek'])->name('proyek.hapus');
    Route::post('/proyek/{idProyek}/rincian', [OperatorController::class, 'simpanRincian'])->name('rincian.simpan');
    Route::delete('/rincian/{id}', [OperatorController::class, 'hapusRincian'])->name('rincian.hapus');
});
