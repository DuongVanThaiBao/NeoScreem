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
use App\Http\Controllers\BookingController;


Route::get('/booking/{showtime}', [BookingController::class, 'show'])
    ->name('booking.show');

Route::post('/booking/{showtime}/finalize', [BookingController::class, 'finalize'])
    ->name('booking.finalize');
/*
|--------------------------------------------------------------------------
| TRANG CHỦ
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| API BOOKING (RẠP - NGÀY - GIỜ)
|--------------------------------------------------------------------------
*/
Route::get('/api/theaters/{phim_id}', [ShowtimeController::class, 'getTheaters']);
Route::get('/api/dates/{phim_id}/{rap_id}', [ShowtimeController::class, 'getDates']);
Route::get('/api/times/{phim_id}/{rap_id}/{ngay_chieu}', [ShowtimeController::class, 'getTimes']);

/*
|--------------------------------------------------------------------------
| PHIM
|--------------------------------------------------------------------------
*/
Route::get('/showing', [HomeController::class, 'showing'])->name('showing');
Route::get('/upcoming', [HomeController::class, 'upcoming'])->name('upcoming');
Route::get('/phim/{id}', [PhimController::class, 'show'])->name('movie.show');
Route::get('/search', [PhimController::class, 'search'])->name('movie.search');

/*
|--------------------------------------------------------------------------
| ĐẶT VÉ (BOOKING) – BẮT BUỘC ĐĂNG NHẬP
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Trang đặt ghế + snack
    Route::get('/booking/choose/{phim}', [BookingController::class, 'choose'])->name('booking.choose');
    Route::post('/booking/finalize/{showtime}', [BookingController::class, 'finalize'])->name('booking.finalize');
});

/*
|--------------------------------------------------------------------------
| DÙNG NÚT TÌM SUẤT CHIẾU TỪ 4 THAM SỐ
| (phim / rap / ngày / giờ)
|--------------------------------------------------------------------------
*/
Route::get('/booking/find/{phim}/{rap}/{ngay}/{gio}', function ($phim, $rap, $ngay, $gio) {
    $showtime = \App\Models\Showtime::where('movie_id', $phim)
        ->where('rap_id', $rap)
        ->whereDate('ngay_chieu', $ngay)
        ->where('gio_chieu', $gio)
        ->firstOrFail();

    return redirect("/booking/" . $showtime->id);
});

/*
|--------------------------------------------------------------------------
| KHUYẾN MÃI
|--------------------------------------------------------------------------
*/
Route::get('/promotions', [HomeController::class, 'promotionsAndEvents'])
    ->name('promotions.promotions');

/*
|--------------------------------------------------------------------------
| AUTH – ĐĂNG KÝ / ĐĂNG NHẬP
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterMsController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterMsController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| QUÊN MẬT KHẨU
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

/*
|--------------------------------------------------------------------------
| XÁC MINH EMAIL
|--------------------------------------------------------------------------
*/
Route::get('/verify', [VerificationController::class, 'showVerificationForm'])->name('verify.form');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verify.submit');
Route::get('/send-code/{email}', [VerificationController::class, 'sendVerificationCode'])->name('verify.send');

/*
|--------------------------------------------------------------------------
| USER PROFILE – CẦN LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
});

/*
|--------------------------------------------------------------------------
| ADMIN
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
