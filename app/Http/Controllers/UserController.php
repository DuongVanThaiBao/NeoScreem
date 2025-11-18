<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking; // <-- Quan trọng: Phải 'use' Model Booking

class UserController extends Controller
{
    /**
     * Yêu cầu đăng nhập cho tất cả các hàm
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Hiển thị trang hồ sơ cá nhân VÀ lịch sử đặt vé
     */
    public function profile()
    {
        // 1. Lấy thông tin người dùng
        $user = Auth::user();

        // 2. Lấy TẤT CẢ booking của user, sắp xếp mới nhất lên đầu
        $allBookings = Booking::where('user_id', $user->id)
            ->with([
                'showtime.phim',
                'showtime.room.theater',
                'seats',
                'snacks'
            ])
            ->orderBy('created_at', 'desc') // Sắp xếp mới nhất lên đầu
            ->get();

        // 3. Trả về view, gửi cả 2 biến 'user' và 'allBookings'
        return view('user.profile', compact('user', 'allBookings'));
    }
}