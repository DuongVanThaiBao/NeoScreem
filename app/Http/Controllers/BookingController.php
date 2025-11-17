<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Snack;
use App\Models\Showtime;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Hiển thị trang chọn ghế + snack
    public function show($showtimeId)
    {
        // Load showtime kèm movie và room
        $showtime = Showtime::with(['phim', 'room.seats'])->findOrFail($showtimeId);

        $phim = $showtime->phim; // Lấy phim từ showtime
        $snacks = Snack::all();   // Lấy tất cả snack

        return view('booking.choose', compact('showtime', 'phim', 'snacks'));
    }

    public function choose($phimId)
    {
        // Lấy tất cả suất chiếu của phim
        $showtimes = Showtime::where('phim_id', $phimId)->with('room.seats')->get();

        $phim = $showtimes->first()->phim ?? null; // Lấy phim từ suất chiếu đầu tiên
        $snacks = Snack::all();   // Lấy tất cả snack

        return view('booking.choose', compact('showtimes', 'phim', 'snacks'));
    }

    // Xử lý đặt vé
    public function finalize(Request $request, $showtimeId)
    {
        $showtime = Showtime::findOrFail($showtimeId);

        $request->validate([
            'seats' => 'required|array',
            'seats.*' => 'exists:seats,id',
            'snacks' => 'array',
            'snacks.*' => 'integer|min:0'
        ]);

        $booking = Booking::create([
            'showtime_id' => $showtime->id,
            'khach_hang' => 'Khách vãng lai', // tạm
            'tong_tien' => $showtime->gia_ve * count($request->seats)
        ]);

        // Lưu ghế
        $booking->seats()->attach($request->seats);

        // Lưu snack
        if ($request->snacks) {
            foreach ($request->snacks as $snack_id => $qty) {
                if ($qty > 0) {
                    $booking->snacks()->attach($snack_id, ['so_luong' => $qty]);
                    $booking->tong_tien += Snack::find($snack_id)->gia * $qty;
                }
            }
            $booking->save();
        }

        return redirect()->route('booking.success', $booking->id);
    }

    // Trang thành công
    public function success($bookingId)
    {
        $booking = Booking::with(['showtime.movie', 'seats', 'snacks'])->findOrFail($bookingId);
        return view('booking.success', compact('booking'));
    }
}
