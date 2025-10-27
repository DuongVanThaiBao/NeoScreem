<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User thường sẽ được tạo tự nhiên thông qua hệ thống đăng ký
        // Khi người dùng đăng ký thành công, họ sẽ trở thành user với role = 'user'
        // Không cần tạo user mẫu cố định ở đây

        // Thông tin đăng nhập user thường:
        // - Email: Bất kỳ email nào người dùng đăng ký
        // - Password: Người dùng tự đặt khi đăng ký
        // - Role: 'user' (tự động gán khi đăng ký thành công)
    }
}
