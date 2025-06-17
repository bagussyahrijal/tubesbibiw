<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('login');
})->name('home');

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/password/request', [AuthController::class, 'showPasswordRequest'])->name('password.request');

Route::middleware(['auth', EnsureAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/manageusers', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::post('/admin/manageusers', [AdminController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/manageorders', [AdminController::class, 'manageOrders'])->name('admin.orders');
    Route::patch('/admini/manageorders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.updateStatus');
});
