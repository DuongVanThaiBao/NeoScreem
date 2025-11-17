<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SnackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('snacks')->insert([
            ['ten' => 'Popcorn', 'gia' => 30000, 'anh' => 'snacks/popcorn.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['ten' => 'Coca Cola', 'gia' => 20000, 'anh' => 'snacks/coke.jpg', 'created_at' => now(), 'updated_at' => now()],
            ['ten' => 'Combo Snack', 'gia' => 50000, 'anh' => 'snacks/combo.jpg', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
