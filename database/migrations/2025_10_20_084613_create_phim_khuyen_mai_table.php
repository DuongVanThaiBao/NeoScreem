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
            $table->id();
            $table->foreignId('phim_id')->constrained('phim')->onDelete('cascade'); // bảng 'phim'
            $table->string('ten');
            $table->decimal('gia_giam', 10, 2);
            $table->timestamps();
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
