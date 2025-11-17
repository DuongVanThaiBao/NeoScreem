<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSeat extends Model
{
    use HasFactory;

    // Đây là bảng trung gian cho Booking và Seat
    protected $table = 'booking_seats';
    protected $fillable = ['booking_id', 'seat_id'];
    public $timestamps = false;
}
