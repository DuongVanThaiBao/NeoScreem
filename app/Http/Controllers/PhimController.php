<?php

namespace App\Http\Controllers;

use App\Models\Phim;
use Illuminate\Http\Request;

class PhimController extends Controller
{
    public function movie()
    {
        $phimDangChieu = Phim::where('trang_thai', 'Đang chiếu')->get();
        $phimSapChieu  = Phim::where('trang_thai', 'Sắp chiếu')->get();

        return view('phim.index', compact('phimDangChieu', 'phimSapChieu'));
    }
}
