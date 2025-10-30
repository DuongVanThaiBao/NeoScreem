<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KhuyenMai;

class KhuyenMaiSeeder extends Seeder
{
    public function run()
    {
        $vouchers = [
            [
                'ten_khuyen_mai' => 'Tri Ân Khách Hàng - Giảm 20K',
                'mo_ta' => 'Giảm ngay 20.000đ cho đơn hàng từ 100.000đ. Cảm ơn bạn đã đồng hành cùng NeoScreem!',
                'anh_banner' => 'banners/voucher_trian.jpg',
                'so_tien_giam_gia' => 20000,
                'rules' => ['min_order' => 100000, 'discount' => 20000],
                'trang_thai' => 1,
                'ngay_bat_dau' => '2025-10-20',
                'ngay_ket_thuc' => '2025-12-31',
            ],
            [
                'ten_khuyen_mai' => 'Mừng Cuối Tuần - Giảm 15%',
                'mo_ta' => 'Cuối tuần rực rỡ! Giảm 15% cho tất cả vé khi đặt online vào Thứ 6 - Chủ nhật.',
                'anh_banner' => 'banners/voucher_weekend.jpg',
                'phan_tram_giam_gia' => 15,
                'rules' => ['apply_days' => ['Fri', 'Sat', 'Sun']],
                'trang_thai' => 1,
                'ngay_bat_dau' => '2025-10-25',
                'ngay_ket_thuc' => '2025-12-31',
            ],
            [
                'ten_khuyen_mai' => 'Suất Khuya Siêu Tiết Kiệm',
                'mo_ta' => 'Giảm 25% cho các suất chiếu sau 22h. Thưởng thức phim muộn cùng bạn bè!',
                'anh_banner' => 'banners/voucher_night.jpg',
                'phan_tram_giam_gia' => 25,
                'rules' => ['time_after' => '22:00'],
                'trang_thai' => 1,
                'ngay_bat_dau' => '2025-10-21',
                'ngay_ket_thuc' => '2025-11-30',
            ],
            [
                'ten_khuyen_mai' => 'Combo Bắp Nước Ưu Đãi - Giảm 10K',
                'mo_ta' => 'Mua combo bắp nước cùng vé xem phim, giảm ngay 10.000đ!',
                'anh_banner' => 'banners/voucher_combo.jpg',
                'so_tien_giam_gia' => 10000,
                'rules' => ['combo_required' => true],
                'trang_thai' => 1,
                'ngay_bat_dau' => '2025-10-22',
                'ngay_ket_thuc' => '2025-12-31',
            ],
            [
                'ten_khuyen_mai' => 'Thành Viên Mới - Giảm 30K',
                'mo_ta' => 'Chào mừng thành viên mới của NeoScreem! Giảm ngay 30.000đ cho đơn hàng đầu tiên.',
                'anh_banner' => 'banners/voucher_newuser.jpg',
                'so_tien_giam_gia' => 30000,
                'rules' => ['first_order_only' => true],
                'trang_thai' => 1,
                'ngay_bat_dau' => '2025-10-20',
                'ngay_ket_thuc' => '2026-01-01',
            ],
            [
                'ten_khuyen_mai' => 'Thứ Tư Vui Vẻ - Đồng Giá 45K',
                'mo_ta' => 'Ưu đãi đặc biệt dành cho thành viên của NeoScreem vào mỗi Thứ Tư hàng tuần. Thưởng thức phim hay với giá vé chỉ 45,000đ.',
                'anh_banner' => 'banners/voucher_wednesday.jpg',
                'phan_tram_giam_gia' => null,
                'so_tien_giam_gia' => null,
                'rules' => ['dayOfWeek' => 3, 'member_required' => true],
                'trang_thai' => 1,
                'ngay_bat_dau' => '2025-10-21',
                'ngay_ket_thuc' => '2025-12-31',
            ],
        ];

        foreach ($vouchers as $v) {
            KhuyenMai::create($v);
        }
    }
}
