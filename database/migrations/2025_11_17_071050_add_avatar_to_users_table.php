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
        Schema::table('users', function (Blueprint $table) {
            // Thêm cột 'avatar', kiểu string, cho phép rỗng (nullable)
            // Đặt sau cột 'email' (hoặc bất cứ cột nào bạn muốn)
            $table->string('avatar')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Xóa cột 'avatar' nếu rollback
            $table->dropColumn('avatar');
        });
    }
};
