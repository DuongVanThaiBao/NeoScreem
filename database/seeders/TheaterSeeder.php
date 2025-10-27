<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TheaterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('theaters')->insert([
            [
                'name' => 'NeoScreem Cineplex Hà Nội',
                'location' => 'Tầng 4, Vincom Center Bà Triệu, Hà Nội',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NeoScreem Cineplex TP. Hồ Chí Minh',
                'location' => 'Tầng 5, AEON Mall Tân Phú, TP. Hồ Chí Minh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'NeoScreem Cineplex Đà Nẵng',
                'location' => 'Tầng 3, Vincom Plaza Ngô Quyền, Đà Nẵng',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
