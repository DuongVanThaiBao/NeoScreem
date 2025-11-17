<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShowtimeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('showtimes')->insert([
    [
        'phim_id' => 1,
        'rap_id' => 1,
        'room_id' => 1, // phải có
        'ngay_chieu' => '2025-10-26',
        'gio_chieu' => '19:00:00',
        'gia_ve' => 80000,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'phim_id' => 1,
        'rap_id' => 2,
        'room_id' => 2, // phải có
        'ngay_chieu' => '2025-10-27',
        'gio_chieu' => '21:00:00',
        'gia_ve' => 90000,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'phim_id' => 2,
        'rap_id' => 3,
        'room_id' => 3, // phải có
        'ngay_chieu' => '2025-10-28',
        'gio_chieu' => '18:30:00',
        'gia_ve' => 85000,
        'created_at' => now(),
        'updated_at' => now(),
    ]
]);

    }
}
