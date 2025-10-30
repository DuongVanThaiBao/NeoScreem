<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Users;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TheaterSeeder::class,
            UserSeeder::class,
            AdminUserSeeder::class,
            PhimSeeder::class,
            KhuyenMaiSeeder::class, 
            ShowtimeSeeder::class, 
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(PhimSeeder::class);
    }
}
