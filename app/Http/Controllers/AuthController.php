<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login'); // tạo file resources/views/auth/login.blade.php
    }

    // Xử lý đăng nhập (ví dụ đơn giản, chưa dùng Auth)
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Ví dụ kiểm tra cứng (chưa kết nối DB, chưa hash)
        if ($email === 'admin@cinema.com' && $password === '123456') {
            // Lưu session để giả lập đăng nhập
            session(['user' => $email]);
            return redirect('/dashboard')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors(['email' => 'Sai email hoặc mật khẩu!']);
    }
}
