<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    public function showVerificationForm(Request $request)
    {
        //💡 CẢI THIỆN: Kiểm tra session trước khi hiển thị view
        if (!session()->has('email')) {
            return redirect('/register')->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }

        return view('auth.verify', ['email' => session('email')]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)
            ->where('verification_code', $request->code)
            ->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->verification_code = null; // Rất tốt khi xóa code sau khi dùng
            $user->save();

            return redirect('/login')->with('success', '✅ Verification successful! You can log in.');
        }

        session(['email' => $request->email]);

        return back()->with('error', '❌ Verification code is incorrect!');
    }

    /**
     * Gửi lại mã xác minh.
     * ✅ SỬA LỖI: Nhận $email trực tiếp từ tham số của Route.
     */
    public function sendVerificationCode(string $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Có thể chuyển hướng về trang đăng ký thay vì quay lại
            return redirect('/register')->with('error', 'Email không tồn tại.');
        }

        // Tạo mã ngẫu nhiên 6 số
        $code = rand(100000, 999999);
        $user->verification_code = $code;
        $user->save();

        // Gửi mail
        Mail::raw("Mã xác minh của bạn là: $code", function ($message) use ($email) {
            $message->to($email)->subject('Mã xác minh tài khoản');
        });

        return back()->with('success', '✅ Mã xác minh mới đã được gửi đến email của bạn!');
    }
}