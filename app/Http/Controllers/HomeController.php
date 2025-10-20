<?php

namespace App\Http\Controllers;

use App\Models\Phim;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        // Lấy danh sách phim đang chiếu và sắp chiếu từ bảng 'phim'
        $phimDangChieu = \App\Models\Phim::where('trang_thai', 'đang chiếu')->take(10)->get();
        $phimSapChieu  = \App\Models\Phim::where('trang_thai', 'sắp chiếu')->take(10)->get();

        // Trả dữ liệu ra view
        return view('home', compact('phimDangChieu', 'phimSapChieu'));
    }
}

