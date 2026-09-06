<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Route;

// Public Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Guard: admin)
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/identity', [AdminController::class, 'updateIdentity'])->name('identity.update');
    Route::post('/operators', [AdminController::class, 'storeOperator'])->name('operators.store');
    Route::delete('/operators/{id}', [AdminController::class, 'destroyOperator'])->name('operators.destroy');
});

// Operator Routes (Guard: operator)
Route::middleware('auth:operator')->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dashboard', [OperatorController::class, 'dashboard'])->name('dashboard');
    Route::post('/locations', [OperatorController::class, 'storeLocation'])->name('locations.store');
    Route::delete('/locations/{id}', [OperatorController::class, 'destroyLocation'])->name('locations.destroy');
    Route::post('/projects', [OperatorController::class, 'storeProject'])->name('projects.store');
    Route::delete('/projects/{id}', [OperatorController::class, 'destroyProject'])->name('projects.destroy');
    Route::post('/projects/{projectId}/details', [OperatorController::class, 'storeDetail'])->name('details.store');
    Route::delete('/details/{id}', [OperatorController::class, 'destroyDetail'])->name('details.destroy');
});
