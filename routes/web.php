<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\OrderController; // Make sure this line exists
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('index');
})->name('home');

// Public routes
Route::get('/pricing', [PaymentController::class, 'pricing'])->name('pricing');

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Order Routes - Make sure these are here
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // Address Routes
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses');
    Route::get('/addresses/add', [AddressController::class, 'create'])->name('addresses.add');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
    Route::put('/addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');

    // Schedule Routes
    Route::get('/schedule', [ScheduleController::class, 'create'])->name('schedule.create');
    Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');

    // Payment Routes
    Route::get('/payment-methods', [PaymentController::class, 'index'])->name('payment.methods');
    Route::post('/payment-methods', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('payment.process');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    // Support Routes
    Route::get('/support', [SupportController::class, 'index'])->name('support');
    Route::post('/support', [SupportController::class, 'store'])->name('support.store');

    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings/account', [SettingsController::class, 'updateAccount'])->name('settings.account');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
    Route::put('/settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications');
    Route::get('/settings/export', [SettingsController::class, 'exportData'])->name('settings.export');
    Route::delete('/settings/account', [SettingsController::class, 'deleteAccount'])->name('settings.delete');
});

Route::middleware(['auth', EnsureAdmin::class])->group(function () {
    // Admin Routes
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/manageusers', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::post('/admin/manageusers', [AdminController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/manageorders', [AdminController::class, 'manageOrders'])->name('admin.orders');
});
