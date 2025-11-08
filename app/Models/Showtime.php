<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $table = 'showtimes';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'phim_id',
        'rap_id', // SỬA: Khớp với DB (có 's')
        'ngay_chieu',  // SỬA: Khớp với DB
        'gio_chieu',   // SỬA: Khớp với DB
        'gia_ve',
        'dinh_dang'
    ];

    public function movie()
    {
        return $this->belongsTo(Phim::class, 'phim_id');
    }

    // SỬA: Đổi tên quan hệ và khóa ngoại
    public function theater()
    {
        return $this->belongsTo(Theater::class, 'rap_id'); // Dùng 'rap_id'
    }
}