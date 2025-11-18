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
        // Tên bảng phải khớp: 'booking_seat'
        Schema::create('booking_seat', function (Blueprint $table) {
            // Không cần cột id()
            
            // Cột foreign key cho Booking
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            
            // Cột foreign key cho Seat
            $table->foreignId('seat_id')->constrained()->onDelete('cascade');

            // (Nên có) Đặt khóa chính 2 cột để tránh trùng lặp
            $table->primary(['booking_id', 'seat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_seat');
    }
};