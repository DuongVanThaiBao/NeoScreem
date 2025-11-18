<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// 1. Đảm bảo bạn CÓ ĐỦ 4 dòng 'use' này
use App\Models\Showtime;
use App\Models\User;
use App\Models\Seat;
use App\Models\Snack;

class Booking extends Model
{
    use HasFactory;

    /**
     * Các cột được phép gán hàng loạt
     */
    protected $fillable = [
        'showtime_id',
        'user_id',
        'khach_hang',
        'total_price',
        'so_luong_ghe', // Cột số lượng ghế
        'status',
    ];

    /**
     * Lấy suất chiếu của booking.
     */
    public function showtime(): BelongsTo
    {
        return $this->belongsTo(Showtime::class);
    }

    /**
     * Lấy người dùng đã đặt vé.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy TẤT CẢ các ghế trong booking này.
     */
    public function seats(): BelongsToMany
    {
        return $this->belongsToMany(Seat::class, 'booking_seat');
    }

    /**
     * Lấy TẤT CẢ các snack trong booking này.
     */
    public function snacks(): BelongsToMany
    {
        return $this->belongsToMany(Snack::class, 'booking_snack')
                   ->withPivot('so_luong');
    }
}