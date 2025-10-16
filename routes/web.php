<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterMsController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Auth; // Thêm dòng này để sử dụng Auth facade

// use App\Http\Controllers\Admin\AdminController; // Dòng này không còn cần thiết nữa

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

// === PHẦN SỬA ĐỔI NẰM Ở ĐÂY ===
// Chỉ yêu cầu đăng nhập, không cần middleware 'admin' nữa
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        // Kiểm tra quyền admin trực tiếp ở đây
        if (Auth::user()->role === 'admin') {
            // Nếu là admin, hiển thị trang dashboard
            return view('admin.dashboard');
        }

        // Nếu không phải admin, trả về lỗi 403 (Forbidden)
        abort(403, 'BẠN KHÔNG CÓ QUYỀN TRUY CẬP TRANG NÀY.');
    })->name('admin.dashboard');
});

// Forgot Password
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

// Reset Password
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

