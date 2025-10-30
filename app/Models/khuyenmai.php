<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class KhuyenMai extends Model
{
    use HasFactory;

    protected $table = 'khuyen_mai'; // ⚠️ Đảm bảo đúng với tên bảng trong DB
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'ten_khuyen_mai',
        'mo_ta',
        'anh_banner',
        'phan_tram_giam_gia',
        'so_tien_giam_gia',
        'dieu_kien_ap_dung',
        'rules',
        'trang_thai',
        'ngay_bat_dau',
        'ngay_ket_thuc',
    ];

    protected $casts = [
        'ngay_bat_dau' => 'datetime',
        'ngay_ket_thuc' => 'datetime',
        'trang_thai' => 'boolean',
        'rules' => 'array',
    ];

    /**
     * Quan hệ nhiều-nhiều với model Phim.
     * Bảng trung gian: phim_khuyen_mai (phải có 2 cột: phim_id và khuyen_mai_id)
     */
    public function phims()
    {
        return $this->belongsToMany(Phim::class, 'phim_khuyen_mai', 'khuyen_mai_id', 'phim_id');
    }

    /**
     * Scope: chỉ lấy các khuyến mãi còn hiệu lực và đang bật.
     */
    public function scopeActive($query)
    {
        $today = Carbon::today();
        return $query->where('trang_thai', true)
            ->where('ngay_bat_dau', '<=', $today)
            ->where('ngay_ket_thuc', '>=', $today);
    }
}
