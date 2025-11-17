<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'showtime_id',
        'seats',      // dạng JSON: ["A1","A2"]
        'total_price',
        'status'
    ];

    protected $casts = [
        'seats' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }

    public function bookingSnacks()
    {
        return $this->hasMany(BookingSnack::class, 'booking_id');
    }

    public function getTotalWithSnacksAttribute()
    {
        $snackTotal = $this->bookingSnacks->sum('thanh_tien');
        return (float) $this->total_price + (float) $snackTotal;
    }
}
