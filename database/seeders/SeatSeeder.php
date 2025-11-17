<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Seat;

class SeatSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy tất cả các phòng
        $rooms = Room::all();

        foreach ($rooms as $room) {
            // Ví dụ tạo 5 hàng A-E, 10 ghế mỗi hàng
            $rows = ['A','B','C','D','E'];
            $cols = range(1,10);

            foreach ($rows as $row) {
                foreach ($cols as $col) {
                    Seat::create([
                        'room_id' => $room->id,
                        'hang' => $row,
                        'cot' => $col,
                        'loai' => $row == 'A' ? 'vip' : 'thuong' // Hàng A là VIP
                    ]);
                }
            }
        }
    }
}
