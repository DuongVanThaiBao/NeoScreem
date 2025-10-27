<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Authentication (Xác thực người dùng) và User Authorization (Phân quyền người dùng)
        // User: Tất cả những người đã đăng ký, có tài khoản và có thể đăng nhập.
        // Role-based Access Control (RBAC): Dùng trường role để phân quyền (admin, user, etc).
        // Admin cũng là một loại user đặc biệt, có quyền cao hơn.
        // Tất cả người đăng ký thành công đều là "users" của hệ thống.

        // Tạo tài khoản admin mặc định để truy cập Admin Portal
        $this->call(AdminUserSeeder::class);

        // Thông tin đăng nhập User thường:
        // - Email: Bất kỳ email nào người dùng đăng ký thông qua form đăng ký
        // - Password: Người dùng tự đặt khi đăng ký
        // - Role: 'user' (tự động gán khi đăng ký thành công)
        // - User thường được tạo tự nhiên thông qua hệ thống đăng ký, không cần tạo mẫu

        // Seed thống kê dashboard
        $this->call(StatisticsSeeder::class);
    }
}
