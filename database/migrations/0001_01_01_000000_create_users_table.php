<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Bảng users
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // khóa chính
            $table->string('name'); // tên người dùng
            $table->string('email')->unique(); // email duy nhất
            $table->timestamp('email_verified_at')->nullable(); // xác thực email
            $table->string('password'); // mật khẩu
            $table->string('role')->default('user'); // phân quyền: user/admin
            $table->rememberToken(); // token "remember me"
            $table->timestamps(); // created_at + updated_at
        });

        // Bảng reset password
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Bảng sessions (dùng cho quản lý session trong Laravel)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
