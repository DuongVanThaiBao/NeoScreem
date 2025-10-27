<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@neoscreem.com'], // Tìm user bằng email để tránh tạo trùng
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'), // Mật khẩu admin123
                'role' => 'admin',
            ]
        );
    }
}
