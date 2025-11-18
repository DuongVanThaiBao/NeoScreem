<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phim;
use App\Models\Theater;
use App\Models\KhuyenMai;

class HomeController extends Controller
{
    public function index()
    {
        $phimDangChieu = Phim::where('trang_thai', 'Đang chiếu')->get();
        $phimSapChieu = Phim::where('trang_thai', 'Sắp chiếu')->get();
        $promotions = KhuyenMai::active()->get();
        $movies = Phim::where('trang_thai', 'Đang chiếu')->get();
        $theaters = Theater::all();

        return view('home', compact('phimDangChieu', 'phimSapChieu', 'promotions', 'movies', 'theaters'));
    }

    public function promotionsAndEvents()
    {
        $promotions = KhuyenMai::active()->get();
        return view('promotions.promotions', compact('promotions'));
    }

    public function showing()
    {
        $phimDangChieu = Phim::where('trang_thai', 'Đang chiếu')->get();
        $movies = Phim::where('trang_thai', 'Đang chiếu')->get();
        return view('movie.showing', compact('phimDangChieu', 'movies'));
    }

    public function upcoming()
    {
        $phimSapChieu = Phim::where('trang_thai', 'Sắp chiếu')->get();
        $movies = Phim::where('trang_thai', 'Sắp chiếu')->get();
        return view('movie.upcoming', compact('phimSapChieu', 'movies'));
    }
}
