<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLogin()
    {
        return view('auth.login');
    }

    public function index()
    {
        $phimDangChieu = \App\Models\Phim::where('trang_thai', 'dang_chieu')->take(10)->get();
        $phimSapChieu  = \App\Models\Phim::where('trang_thai', 'sap_chieu')->take(10)->get();

        return view('home', compact('phimDangChieu', 'phimSapChieu'));
    }
    public function login(Request $request)
    {
        // Validate dữ liệu
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Kiểm tra thông tin đăng nhập
        if (Auth::attempt($credentials)) {
            // Tạo lại session ID để tránh tấn công session fixation
            $request->session()->regenerate();

            // === PHẦN SỬA ĐỔI BẮT ĐẦU TỪ ĐÂY ===

            // Lấy thông tin người dùng vừa đăng nhập
            $user = Auth::user();

            // Kiểm tra role của người dùng
            if ($user->role === 'admin') {
                // Nếu là admin, chuyển hướng đến trang dashboard của admin
                // Giả sử bạn có route tên là 'admin.dashboard'
                return redirect()->route('admin.dashboard')->with('success', 'Chào mừng Admin quay trở lại!');
            }

            // Nếu là user thường, chuyển hướng đến trang home
            return redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công!');

            // === KẾT THÚC PHẦN SỬA ĐỔI ===
        }

        // Nếu sai thông tin đăng nhập
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    /**
     * Đăng xuất
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Hủy session hiện tại
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Bạn đã đăng xuất thành công!');
    }
}

