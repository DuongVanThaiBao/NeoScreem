<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location'];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function showtimes()
    {
        return $this->hasMany(Showtime::class, 'rap_id');
    }
}
