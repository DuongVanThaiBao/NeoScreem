<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\RegisterMsController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PhimController;
use App\Http\Controllers\ShowtimeController;

/*
|--------------------------------------------------------------------------
| ROUTES CHÍNH CHO WEBSITE
|--------------------------------------------------------------------------
*/

// 🏠 TRANG CHỦ
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/api/theaters/{phim_id}', [ShowtimeController::class, 'getTheaters']);
Route::get('/api/dates/{phim_id}/{rap_id}', [ShowtimeController::class, 'getDates']);
Route::get('/api/times/{phim_id}/{rap_id}/{ngay_chieu}', [ShowtimeController::class, 'getTimes']);
// 🎬 PHIM (đang chiếu / sắp chiếu)
Route::get('/showing', [HomeController::class, 'showing'])->name('showing');
Route::get('/upcoming', [HomeController::class, 'upcoming'])->name('upcoming');

// 🔍 TÌM KIẾM PHIM
Route::get('/search', [PhimController::class, 'search'])->name('movie.search');

// 🎫 ĐẶT VÉ (liên kết phim - rạp - giờ)
Route::get('/get-raps/{phim_id}', [HomeController::class, 'getRaps'])->name('booking.getRaps');
Route::get('/get-times/{phim_id}/{rap_id}', [HomeController::class, 'getTimes'])->name('booking.getTimes');

// 💥 KHUYẾN MÃI & SỰ KIỆN
Route::get('/promotions', [HomeController::class, 'promotionsAndEvents'])->name('promotions.promotions');

/*
|--------------------------------------------------------------------------
| XÁC THỰC NGƯỜI DÙNG
|--------------------------------------------------------------------------
*/

// 🧍 ĐĂNG KÝ

Route::get('/register', [RegisterMsController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterMsController::class, 'register']);

// 🔑 ĐĂNG NHẬP / ĐĂNG XUẤT
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 📨 QUÊN MẬT KHẨU / ĐẶT LẠI MẬT KHẨU
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

// ✅ XÁC MINH EMAIL
Route::get('/verify', [VerificationController::class, 'showVerificationForm'])->name('verify.form');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verify.check');

// Gửi mã (ví dụ sau khi đăng ký xong)
Route::get('/send-code/{email}', [VerificationController::class, 'sendVerificationCode'])->name('verify.send');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verify.submit');
/*
|--------------------------------------------------------------------------
| KHU VỰC NGƯỜI DÙNG (YÊU CẦU ĐĂNG NHẬP)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
});

/*
|--------------------------------------------------------------------------
| KHU VỰC ADMIN (YÊU CẦU ĐĂNG NHẬP + ROLE ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        if (Auth::user()->role === 'admin') {
            return view('admin.dashboard');
        }
        abort(403, 'Bạn không có quyền truy cập trang này.');
    })->name('admin.dashboard');
});
