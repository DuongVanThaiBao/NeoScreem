<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phim', function (Blueprint $table) {
            $table->id();
            $table->string('ten_phim');
            $table->string('dao_dien')->nullable();
            $table->string('dien_vien')->nullable();
            $table->string('the_loai')->nullable();
            $table->integer('thoi_luong')->nullable()->comment('Đơn vị: phút');
            $table->string('ngon_ngu')->default('Việt / Anh');
            $table->string('quoc_gia')->nullable();
            $table->date('ngay_khoi_chieu');
            $table->date('ngay_ket_thuc')->nullable();
            $table->text('tom_tat')->nullable();
            $table->string('trailer_url')->nullable();
            $table->string('anh_poster')->nullable();
            $table->string('anh_banner')->nullable();
            $table->integer('do_tuoi')->default(13);
            $table->decimal('danh_gia', 2, 1)->default(0.0);
            $table->enum('trang_thai', ['Sắp chiếu', 'Đang chiếu', 'Ngừng chiếu'])->default('Sắp chiếu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phim');
    }
};
