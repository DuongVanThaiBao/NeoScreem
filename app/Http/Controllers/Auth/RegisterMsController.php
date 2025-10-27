<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterMsController extends Controller
{
    // Show register form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

         $code = rand(100000, 999999);
        $user->verification_code = $code;
        $user->save();

        // Gửi mail xác minh
        Mail::raw("Mã xác minh tài khoản của bạn là: $code", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Xác minh tài khoản NeoScreem');
        });

        // Chuyển đến trang xác minh với thông báo thành công
        return redirect()->route('verify.form')->with('success', 'Đăng ký thành công! Vui lòng kiểm tra email để xác minh tài khoản.');

        Auth::login($user);
        return redirect()->route('home')->with('success', 'Register successful!');
    }
}
