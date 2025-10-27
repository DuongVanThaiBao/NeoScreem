<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VerificationController extends Controller
{
    // ✅ Hiển thị form xác minh
    public function showVerificationForm($email)
    {
        return view('auth.verify', compact('email'));
    }

    // ✅ Gửi lại mã xác minh
    public function sendVerificationCode($email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'Email không tồn tại.');
        }

        $code = rand(100000, 999999);
        $user->verification_code = $code;
        $user->code_sent_at = Carbon::now();
        $user->save();

        Mail::raw("Mã xác minh tài khoản của bạn là: $code", function ($message) use ($user) {
            $message->to($user->email)->subject('Mã xác minh tài khoản NeoScreem');
        });

        return back()->with('success', 'Mã xác minh mới đã được gửi tới email của bạn.');
    }

    // ✅ Xác minh mã
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email không tồn tại.');
        }

        if ($user->verification_code == $request->code) {
            $user->email_verified_at = Carbon::now();
            $user->verification_code = null;
            $user->is_verified = true;
            $user->save();

            Auth::login($user);

            return redirect()->route('login')->with('success', 'Xác minh thành công! Bạn đã được đăng nhập.');
        }

        return back()->with('error', 'Mã xác minh không chính xác.');
    }
}
