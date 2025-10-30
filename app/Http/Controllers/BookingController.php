<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phim;
use App\Models\Theater;
use App\Models\Showtime;

class BookingController extends Controller
{
    public function index()
    {
        $phims = Phim::all();
        $theaters = Theater::all();
        return view('booking.index', compact('phims', 'theaters'));
    }

    public function getRaps($phim_id)
    {
        $raps = Theater::whereHas('showtimes', function ($query) use ($phim_id) {
            $query->where('movie_id', $phim_id);
        })->get();

        return response()->json($raps);
    }

    public function getTimes($phim_id, $rap_id)
    {
        $showtimes = Showtime::where('movie_id', $phim_id)
            ->where('theater_id', $rap_id)
            ->get(['show_time', 'show_date']);
        return response()->json($showtimes);
    }
}
