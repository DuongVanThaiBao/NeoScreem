<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers cho xác thực
use App\Http\Controllers\Auth\RegisterMsController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

// Controllers cho ứng dụng
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PhimController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| ROUTE CÔNG KHAI (Public)
|--------------------------------------------------------------------------
*/

// Trang chủ & Phim
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/showing', [HomeController::class, 'showing'])->name('showing');
Route::get('/upcoming', [HomeController::class, 'upcoming'])->name('upcoming');
Route::get('/phim/{id}', [PhimController::class, 'show'])->name('movie.show');
Route::get('/search', [PhimController::class, 'search'])->name('movie.search');
Route::get('/promotions', [HomeController::class, 'promotionsAndEvents'])->name('promotions.promotions');

// API (Dùng cho Javascript)
Route::get('/api/theaters/{phim_id}', [ShowtimeController::class, 'getTheaters']);
Route::get('/api/dates/{phim_id}/{rap_id}', [ShowtimeController::class, 'getDates']);
Route::get('/api/times/{phim_id}/{rap_id}/{ngay_chieu}', [ShowtimeController::class, 'getTimes']);

// Xác thực (Auth)
Route::get('/register', [RegisterMsController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterMsController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
Route::get('/verify', [VerificationController::class, 'showVerificationForm'])->name('verify.form');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verify.submit');
Route::get('/send-code/{email}', [VerificationController::class, 'sendVerificationCode'])->name('verify.send');

// Route tìm suất chiếu (từ 4 tham số)
Route::get('/booking/find/{phim}/{rap}/{ngay}/{gio}', function ($phim, $rap, $ngay, $gio) {
    $showtime = \App\Models\Showtime::where('movie_id', $phim)
        ->where('rap_id', $rap)
        ->whereDate('ngay_chieu', $ngay)
        ->where('gio_chieu', $gio)
        ->firstOrFail();

    // Chuyển đến route 'booking.show' chuẩn
    return redirect()->route('booking.show', ['showtimeId' => $showtime->id]);
});


/*
|--------------------------------------------------------------------------
| KHU VỰC BẮT BUỘC ĐĂNG NHẬP (auth)
| (ĐÃ GỘP TẤT CẢ VÀO MỘT NHÓM DUY NHẤT)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // --- User Profile ---
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');

    // --- Booking (Xử lý 1 booking) ---
    Route::get('/booking/choose/{phim}', [BookingController::class, 'choose'])->name('booking.choose');
    Route::get('/booking/show/{showtimeId}', [BookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/finalize/{showtimeId}', [BookingController::class, 'finalize'])->name('booking.finalize');
    Route::get('/booking/success/{bookingId}', [BookingController::class, 'success'])->name('booking.success');

    // --- Giỏ Hàng (Cart) (Xử lý nhiều booking) ---
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // --- Admin ---
    Route::prefix('admin')->group(function () {
        Route::get('/', function () {
            if (Auth::user()->role === 'admin') {
                return view('admin.dashboard');
            }
            abort(403, 'Bạn không có quyền truy cập trang này.');
        })->name('admin.dashboard');
    });
});