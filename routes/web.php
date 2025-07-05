<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;


Route::get('/', [RegisterController::class, 'showAdminForm'])->name('register.admin');;
Route::post('/register/admin', [RegisterController::class, 'registerAdmin'])->name('register_admin');

Route::get('/register/customer', [RegisterController::class, 'showCustomerForm'])->name('register.customer');
Route::post('/register/customer', [RegisterController::class, 'registerCustomer'])->name('register_customer');

Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verify.otp');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');




