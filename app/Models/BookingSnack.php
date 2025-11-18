<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSnack extends Model
{
    protected $table = 'booking_snacks';
    protected $fillable = ['booking_id', 'snack_id', 'so_luong', 'thanh_tien'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function snack()
    {
        return $this->belongsTo(Snack::class, 'snack_id');
    }
}
