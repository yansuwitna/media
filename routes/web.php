<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Route;

// Halaman Beranda / Home Publik
Route::get('/', [HomeController::class, 'indeks'])->name('beranda');

// Rute Otentikasi
Route::get('/masuk', [AuthController::class, 'tampilMasuk'])->name('masuk');
Route::post('/masuk', [AuthController::class, 'prosesMasuk'])->name('masuk.proses');
Route::post('/keluar', [AuthController::class, 'keluar'])->name('keluar');

// Rute Admin (Terpisah per Halaman)
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dasbor', [AdminController::class, 'dasbor'])->name('dasbor');
    Route::get('/identitas', [AdminController::class, 'identitas'])->name('identitas');
    Route::post('/identitas', [AdminController::class, 'perbaruiIdentitas'])->name('identitas.perbarui');
    Route::get('/operator', [AdminController::class, 'operator'])->name('operator');
    Route::post('/operator', [AdminController::class, 'simpanOperator'])->name('operator.simpan');
    Route::delete('/operator/{id}', [AdminController::class, 'hapusOperator'])->name('operator.hapus');
});

// Rute Operator (Terpisah per Halaman: Dasbor, Proyek, Kanal Unggah)
Route::middleware('auth:operator')->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dasbor', [OperatorController::class, 'dasbor'])->name('dasbor');
    Route::get('/proyek', [OperatorController::class, 'proyek'])->name('proyek');
    Route::get('/proyek/{id}', [OperatorController::class, 'detailProyek'])->name('proyek.detail');
    Route::get('/lokasi', [OperatorController::class, 'lokasi'])->name('lokasi');
    Route::get('/lokasi/{id}', [OperatorController::class, 'detailLokasi'])->name('lokasi.detail');
    Route::post('/lokasi', [OperatorController::class, 'simpanLokasi'])->name('lokasi.simpan');
    Route::delete('/lokasi/{id}', [OperatorController::class, 'hapusLokasi'])->name('lokasi.hapus');
    Route::post('/proyek', [OperatorController::class, 'simpanProyek'])->name('proyek.simpan');
    Route::put('/proyek/{id}', [OperatorController::class, 'ubahProyek'])->name('proyek.ubah');
    Route::delete('/proyek/{id}', [OperatorController::class, 'hapusProyek'])->name('proyek.hapus');
    Route::post('/proyek/{idProyek}/rincian', [OperatorController::class, 'simpanRincian'])->name('rincian.simpan');
    Route::put('/rincian/{id}', [OperatorController::class, 'ubahRincian'])->name('rincian.ubah');
    Route::delete('/rincian/{id}', [OperatorController::class, 'hapusRincian'])->name('rincian.hapus');
    Route::post('/rincian/{idRincian}/kanal', [OperatorController::class, 'simpanKontenKanal'])->name('rincian.kanal.simpan');
    Route::delete('/konten-kanal/{id}', [OperatorController::class, 'hapusKontenKanal'])->name('rincian.kanal.hapus');
});
