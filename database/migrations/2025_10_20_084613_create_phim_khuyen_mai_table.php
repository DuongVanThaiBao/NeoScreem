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
        // Tên bảng thường là tên 2 bảng ghép lại theo thứ tự alphabet, dạng số ít
        Schema::create('phim_khuyen_mai', function (Blueprint $table) {
            // Khóa ngoại tới bảng 'phim'
            $table->foreignId('phim_id')->constrained('phim')->onDelete('cascade');

            // Khóa ngoại tới bảng 'khuyen_mai'
            $table->foreignId('khuyen_mai_id')->constrained('khuyen_mai')->onDelete('cascade');

            // Thiết lập cả 2 cột trên làm khóa chính σύνθετη (composite primary key)
            // để đảm bảo mỗi cặp (phim, khuyến mãi) chỉ xuất hiện 1 lần.
            $table->primary(['phim_id', 'khuyen_mai_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phim_khuyen_mai');
    }
};
