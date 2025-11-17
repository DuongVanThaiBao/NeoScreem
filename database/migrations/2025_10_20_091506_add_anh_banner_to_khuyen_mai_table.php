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
        Schema::table('khuyen_mai', function (Blueprint $table) {
            // Thêm cột anh_banner kiểu string (VARCHAR), cho phép null, đặt sau cột mo_ta
            $table->string('anh_banner')->nullable()->after('mo_ta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('khuyen_mai', function (Blueprint $table) {
            // Xóa cột nếu rollback migration
            $table->dropColumn('anh_banner');
        });
    }
};