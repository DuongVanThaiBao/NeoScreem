<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Snack;
use App\Models\Showtime;
use App\Models\Seat;
use App\Models\Phim;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Yêu cầu người dùng phải đăng nhập
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * HÀM 1: Hiển thị trang chọn ghế + snack (từ trang chi tiết phim)
     */
    public function choose($phimId)
    {
        $phim = Phim::with('showtimes.room.theater')->findOrFail($phimId);
        $snacks = Snack::all();

        // (Lưu ý: View 'booking.choose' là file bạn gửi)
        return view('booking.choose', compact('phim', 'snacks'));
    }

    /**
     * HÀM 2: Hiển thị trang chọn ghế (khi biết chính xác showtimeId)
     */
    public function show($showtimeId)
    {
        $showtime = Showtime::with(['phim', 'room.seats', 'bookings.seats'])->findOrFail($showtimeId);
        $phim = $showtime->phim; // Lấy phim từ suất chiếu
        $snacks = Snack::all();

        // (Lưu ý: View này sẽ hơi khác view 'choose')
        // Đây là ví dụ, bạn có thể trỏ về 'booking.choose' nếu logic view xử lý được
        return view('booking.show_single', compact('showtime', 'phim', 'snacks'));
    }

    /**
     * HÀM 3: Xử lý và lưu đặt vé (từ trang chọn ghế)
     */
    public function finalize(Request $request, $showtimeId)
    {
        // 1. Lấy người dùng và suất chiếu
        $user = auth()->user();
        $showtime = Showtime::findOrFail($showtimeId);

        // 2. Xác thực dữ liệu
        $request->validate([
            'seats' => 'required|array|min:1',
            'seats.*' => 'exists:seats,id',
            'snacks' => 'nullable|array',
            'snacks.*' => 'integer|min:0'
        ]);

        // 3. Tính toán số lượng và tổng tiền ban đầu
        $soLuongGhe = count($request->seats);
        $tongTien = $showtime->gia_ve * $soLuongGhe;

        // 4. Tạo Booking
        $booking = Booking::create([
            'showtime_id' => $showtime->id,
            'user_id'     => $user->id,
            'khach_hang'  => $user->name,
            'total_price' => $tongTien,
            'so_luong_ghe' => $soLuongGhe,
            'status'      => 'pending', // Trạng thái chờ, sẽ được xử lý ở Giỏ hàng
        ]);

        // 5. Gắn ghế
        $booking->seats()->attach($request->seats);

        // 6. Gắn snack và cập nhật tổng tiền
        if ($request->filled('snacks')) {
            foreach ($request->snacks as $snack_id => $qty) {
                if ($qty > 0) {
                    $snack = Snack::find($snack_id);
                    if ($snack) {
                        $booking->snacks()->attach($snack_id, ['so_luong' => $qty]);
                        $tongTien += $snack->gia * $qty;
                    }
                }
            }
            // Cập nhật lại tổng tiền sau khi cộng snack
            $booking->update(['total_price' => $tongTien]);
        }

        // 7. Chuyển hướng đến trang thành công
        return redirect()->route('booking.success', $booking->id);
    }

    /**
     * HÀM 4: Hiển thị trang đặt vé thành công
     */
    public function success($bookingId)
    {
        $booking = Booking::with([
            'showtime.phim',
            'showtime.room.theater',
            'seats',
            'snacks'
        ])->findOrFail($bookingId);

        return view('booking.success', compact('booking'));
    }
}