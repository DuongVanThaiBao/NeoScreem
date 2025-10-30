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
            ['email' => 'thaibao123xyz@gmail.com'], // Tìm user bằng email để tránh tạo trùng
            [
                'name' => 'Admin',
                'password' => Hash::make('thaibao123xyz'), // Thay mật khẩu ở đây
                'role' => 'admin',
            ]
        );
    }
}
