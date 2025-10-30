<?php

namespace App\Http\Controllers;
use App\Models\Showtime;
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

    public function search(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ query string trên URL (ví dụ: /search?keyword=abc)
        $keyword = $request->input('keyword');

        // Kiểm tra xem từ khóa có tồn tại không (tùy chọn nhưng nên có)
        if (!$keyword) {
            // Chuyển hướng về hoặc hiển thị trang trống nếu không có từ khóa
            return view('search_results', ['results' => collect(), 'keyword' => '']);
        }

        // Thực hiện truy vấn tìm kiếm bằng LIKE
        // Phân trang kết quả (ví dụ: 12 phim mỗi trang)
        $results = Phim::where('ten_phim', 'LIKE', '%' . $keyword . '%')
            ->paginate(12); // Điều chỉnh số lượng mỗi trang nếu cần

        // Trả về view, truyền từ khóa và kết quả tìm được
        return view('search_results', compact('keyword', 'results'));
    }

    protected $fillable = [
        'ten_phim',
        'dao_dien',
        'dien_vien',
        'the_loai',
        'thoi_luong',
        'ngon_ngu',
        'quoc_gia',
        'ngay_khoi_chieu',
        'ngay_ket_thuc',
        'tom_tat',
        'trailer_url',
        'anh_poster',
        'anh_banner',
        'do_tuoi',
        'danh_gia',
        'trang_thai'
    ];

    // 1 phim có nhiều suất chiếu
    public function showtimes()
    {
        return $this->hasMany(Showtime::class, 'movie_id');
    }
}
