<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Theater;

class ShowtimeController extends Controller
{
    // Lấy danh sách rạp có chiếu phim này
    public function getTheaters($phim_id)
    {
        $theaterIds = Showtime::where('phim_id', $phim_id)
            ->pluck('rap_id')
            ->unique();

        $theaters = Theater::whereIn('id', $theaterIds)->get();

        return response()->json($theaters);
    }

    // Lấy danh sách ngày chiếu theo phim + rạp
    public function getDates($phim_id, $rap_id)
    {
        $dates = Showtime::where('phim_id', $phim_id)
            ->where('rap_id', $rap_id)
            ->pluck('ngay_chieu')
            ->unique()
            ->values();

        return response()->json($dates);
    }

    // Lấy giờ chiếu theo phim + rạp + ngày
    public function getTimes($phim_id, $rap_id, $ngay_chieu)
    {
        $times = Showtime::where('phim_id', $phim_id)
            ->where('rap_id', $rap_id)
            ->whereDate('ngay_chieu', $ngay_chieu)
            ->pluck('gio_chieu');

        return response()->json($times);
    }
}
