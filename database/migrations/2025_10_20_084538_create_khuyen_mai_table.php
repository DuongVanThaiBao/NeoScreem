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
        Schema::create('khuyen_mai', function (Blueprint $table) {
            $table->id(); // Tương đương MaKhuyenMai INT PRIMARY KEY AUTO_INCREMENT
            $table->string('ten_khuyen_mai');
            $table->text('mo_ta')->nullable();
            $table->decimal('phan_tram_giam_gia', 5, 2)->nullable()->comment('Ví dụ: 20.00 cho 20%');
            $table->decimal('so_tien_giam_gia', 12, 2)->nullable()->comment('Ví dụ: 50000.00 cho 50,000 VNĐ');
            $table->date('ngay_bat_dau');
            $table->date('ngay_ket_thuc');
            $table->text('dieu_kien_ap_dung')->nullable();
            $table->boolean('trang_thai')->default(true)->comment('true: Kích hoạt, false: Vô hiệu hóa');
            $table->json('rules')->nullable();
            $table->timestamps(); // Tự động tạo cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khuyen_mai');
    }
};
