<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class roomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            ['theater_id' => 1, 'ten_phong' => 'Phòng 1', 'so_ghe' => 50, 'created_at' => now(), 'updated_at' => now()],
            ['theater_id' => 2, 'ten_phong' => 'Phòng 2', 'so_ghe' => 60, 'created_at' => now(), 'updated_at' => now()],
            ['theater_id' => 3, 'ten_phong' => 'Phòng 3', 'so_ghe' => 40, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
