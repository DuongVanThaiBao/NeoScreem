<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    use HasFactory;

    protected $table = 'theaters';
    protected $fillable = [
        'ten_rap',
        'dia_chi',
        'thanh_pho',
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class, 'theater_id');
    }
}
