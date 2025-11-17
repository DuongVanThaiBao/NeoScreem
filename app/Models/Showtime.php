<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Phim;


class Showtime extends Model
{
    protected $fillable = ['phim_id','room_id','ngay_chieu','gio_chieu','gia_ve'];

    public function phim()
    {
        return $this->belongsTo(Phim::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function theater()
    {
        return $this->belongsTo(Theater::class, 'rap_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}



