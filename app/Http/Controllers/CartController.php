<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Yêu cầu đăng nhập
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 1. Hiển thị trang Giỏ hàng
     */
    public function index()
    {
        // Lấy tất cả booking 'pending' (đang chờ) của user
        $bookings = Booking::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->with(['showtime.phim', 'showtime.room.theater', 'seats', 'snacks'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Tính tổng tiền của tất cả booking
        $totalAll = $bookings->sum('total_price'); // Đã sửa 'tong_tien' -> 'total_price'

        return view('cart.index', compact('bookings', 'totalAll'));
    }

    /**
     * 2. Xử lý thanh toán toàn bộ giỏ hàng
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();

        // Lấy TẤT CẢ booking 'pending' của user
        $bookingsToCheckout = Booking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->get();

        if ($bookingsToCheckout->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn rỗng.');
        }

        // (Giả lập thanh toán thành công)
        // Chuyển trạng thái tất cả booking từ 'pending' -> 'completed'
        foreach ($bookingsToCheckout as $booking) {
            $booking->update(['status' => 'completed']);
        }

        // Chuyển hướng đến trang profile (lịch sử đặt vé)
        return redirect()->route('profile')->with('success', 'Thanh toán giỏ hàng thành công!');
    }
}