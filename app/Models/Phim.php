<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phim extends Model
{
    use HasFactory;

    protected $table = 'phim'; // ⚠️ Tên bảng phải trùng trong database (nên để dạng số nhiều)
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'ten_phim',
        'mo_ta',
        'anh_poster',
        'dao_dien',
        'dien_vien',
        'the_loai',
        'thoi_luong',
        'ngay_chieu',
        'trang_thai',
        'ngon_ngu',
        'trailer_url',
        'anh_banner'
    ];

    // Một phim có nhiều suất chiếu
    public function showtimes()
    {
        return $this->hasMany(Showtime::class, 'phim_id');
    }
}
