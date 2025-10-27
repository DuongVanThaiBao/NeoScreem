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
        'movie_id',
        'theater_id',
        'show_date',
        'show_time',
    ];

    public function movie()
    {
        return $this->belongsTo(Phim::class, 'movie_id');
    }

    public function theater()
    {
        return $this->belongsTo(Theater::class, 'theater_id');
    }
}
