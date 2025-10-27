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
        Schema::create('showtimes', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại tới bảng phim
            $table->unsignedBigInteger('phim_id');
            $table->foreign('phim_id')
                ->references('id')
                ->on('phim')
                ->onDelete('cascade');

            // Khóa ngoại tới bảng rạp
            $table->unsignedBigInteger('rap_id');
            $table->foreign('rap_id')
                ->references('id')
                ->on('theaters')
                ->onDelete('cascade');

            // Thông tin suất chiếu
            $table->string('ngay_chieu');
            $table->time('gio_chieu');
            $table->decimal('gia_ve', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showtimes');
    }
};
