<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RegisterMsController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // ✅ Tạo tài khoản mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ✅ Gửi mã xác minh
        $code = rand(100000, 999999);
        $user->verification_code = $code;
        $user->email_verified_at = Carbon::now();
        $user->save();

        Mail::raw("Mã xác minh tài khoản của bạn là: $code", function ($message) use ($user) {
            $message->to($user->email)->subject('Mã xác minh tài khoản NeoScreem');
        });

        // ✅ Chuyển hướng đến trang xác minh và truyền email
        return redirect()->route('verify.form', ['email' => $user->email]);
    }
}
