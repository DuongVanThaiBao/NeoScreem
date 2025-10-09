<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterMsController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\VerificationController;

Route::get('/verify', [VerificationController::class, 'showVerificationForm'])->name('verify.form');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verify.check');

// Gửi mã (ví dụ sau khi đăng ký xong)
Route::get('/send-code/{email}', [VerificationController::class, 'sendVerificationCode'])->name('verify.send');
Route::get('/', [HomeController::class, 'index'])->name('home');

// Register
Route::get('/register', [RegisterMsController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterMsController::class, 'register']);

// Login / Logout
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forgot Password
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

// Reset Password
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
