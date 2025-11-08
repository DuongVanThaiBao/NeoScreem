<?php

namespace App\Http\Controllers;

use App\Models\Phim;
use App\Models\Theater; // <-- THAY ĐỔI: SỬ DỤNG MODEL 'THEATER'
use App\Models\Showtime;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PhimController extends Controller
{
    /**
     * Hiển thị danh sách phim Đang chiếu và Sắp chiếu.
     */
    public function movie()
    {
        $phimDangChieu = Phim::where('trang_thai', 'Đang chiếu')->get();
        $phimSapChieu  = Phim::where('trang_thai', 'Sắp chiếu')->get();
        return view('phim.index', compact('phimDangChieu', 'phimSapChieu'));
    }

    /**
     * Xử lý tìm kiếm phim.
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        if (!$keyword) {
            return view('search_results', ['results' => collect(), 'keyword' => '']);
        }
        $results = Phim::where('ten_phim', 'LIKE', '%' . $keyword . '%')->paginate(12);
        return view('search_results', compact('keyword', 'results'));
    }

    /**
     * Hiển thị trang chi tiết phim và các suất chiếu đã nhóm.
     */
    public function show($id)
    {
        $phim = Phim::findOrFail($id);
        $today = Carbon::today();

        // 1. Lấy suất chiếu sắp tới (Đã cập nhật tên cột)
        $showtimesRaw = $phim->showtimes()
            ->whereDate('ngay_chieu', '>=', $today) // Dùng cột 'ngay_chieu'
            ->with('theater') // <-- THAY ĐỔI: Tải quan hệ 'theater'
            ->orderBy('ngay_chieu') // Dùng cột 'ngay_chieu'
            ->orderBy('gio_chieu') // Dùng cột 'gio_chieu'
            ->get();

        // 2. Lọc an toàn: Chỉ giữ suất chiếu có thông tin Rạp
        $filteredShowtimes = $showtimesRaw->filter(function ($showtime) {
            return $showtime->theater; // <-- THAY ĐỔI: Chỉ giữ nếu quan hệ 'theater' không null
        });

        // 3. Tạo danh sách ngày (động) (Đã cập nhật tên cột)
        $uniqueDateStrings = $filteredShowtimes->map(function ($showtime) {
            return Carbon::parse($showtime->ngay_chieu)->format('Y-m-d'); // Dùng 'ngay_chieu'
        })->unique()->values();

        $dates = $uniqueDateStrings->map(function ($dateString) {
            $date = Carbon::parse($dateString);
            return [
                'value' => $date->format('Y-m-d'),
                'day_month' => $date->format('d/m'),
                'day_of_week_short' => $date->locale('vi')->isoFormat('ddd'),
            ];
        });

        // 4. Lấy danh sách rạp (đã được lọc)
        $cinemaIds = $filteredShowtimes->pluck('rap.id')->unique()->filter(); // <-- THAY ĐỔI: Dùng 'theater'
        $cinemasWithShowtimes = Theater::whereIn('id', $cinemaIds)->get(); // <-- THAY ĐỔI: Dùng Model 'Theater'

        // 5. Nhóm dữ liệu theo Ngày -> Rạp (Đã cập nhật tên cột)
        $showtimesByDate = $filteredShowtimes->groupBy(function ($item) {
            return Carbon::parse($item->ngay_chieu)->format('Y-m-d'); // Dùng 'ngay_chieu'
        })->map(function ($byDate) {
            return $byDate->groupBy('theater.id')->map(function ($byCinema) { // <-- THAY ĐỔI: Dùng 'theater'
                // 'theater' ở đây là tên quan hệ
                return [
                    'ten_rap' => $byCinema->first()->theater->ten_rap, // <-- THAY ĐỔI: Dùng 'theater'
                    'dia_chi' => $byCinema->first()->theater->dia_chi, // <-- THAY ĐỔI: Dùng 'theater'
                    'times' => $byCinema,
                ];
            });
        });

        // 6. Trả về View
        return view('movie.show', [
            'movie' => $phim,
            'dates' => $dates,
            'allCinemas' => $cinemasWithShowtimes,
            'showtimesByDate' => $showtimesByDate,
        ]);
    }

    /**
     * MỚI: Hiển thị trang danh sách tất cả rạp.
     */
    public function listTheaters() // <-- THAY ĐỔI: Tên hàm
    {
        // Lấy tất cả rạp, nhóm theo 'thanh_pho'
        // Sắp xếp theo tên thành phố
        $theatersByCity = Theater::all()->sortBy('thanh_pho')->groupBy('thanh_pho'); // <-- THAY ĐỔI: Dùng Model 'Theater'

        // Trả về view mới, truyền dữ liệu rạp đã nhóm
        return view('theater.index', compact('theatersByCity')); // <-- THAY ĐỔI: Trỏ đến view 'theater.index'
    }
}