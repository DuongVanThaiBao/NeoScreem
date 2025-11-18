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
        // Tên bảng phải khớp: 'booking_snack'
        Schema::create('booking_snack', function (Blueprint $table) {

            // Cột foreign key cho Booking
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');

            // Cột foreign key cho Snack
            $table->foreignId('snack_id')->constrained()->onDelete('cascade');

            // Cột 'so_luong' (BẮT BUỘC, vì bạn đã định nghĩa 'withPivot')
            $table->integer('so_luong');

            // Đặt khóa chính 2 cột để tránh trùng lặp
            $table->primary(['booking_id', 'snack_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_snack');
    }
};