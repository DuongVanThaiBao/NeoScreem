@extends('layouts.app')

@section('content')
<div class="bg-gray-900 text-white min-h-screen">
    <div class="max-w-5xl mx-auto py-12 px-6">
        
        {{-- 1. Thông tin cá nhân (từ biến $user) --}}
        <h2 class="text-3xl font-semibold mb-4">Hồ sơ của: {{ $user->name }}</h2>
        <div class="bg-gray-800 p-4 rounded-lg mb-8">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Ngày tham gia:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
            {{-- Thêm các thông tin khác của user nếu muốn --}}
        </div>

        {{-- 2. Lịch sử đặt vé (từ biến $allBookings) --}}
        <h2 class="text-2xl font-semibold mb-6">Lịch sử đặt vé</h2>

        @forelse($allBookings as $booking)
            @php
                // Đặt màu border dựa trên trạng thái
                $borderColor = 'border-gray-500'; // Mặc định
                if ($booking->status == 'completed') $borderColor = 'border-green-500';
                if ($booking->status == 'pending') $borderColor = 'border-yellow-500';
                if ($booking->status == 'cancelled') $borderColor = 'border-red-500';
            @endphp

            <div class="bg-gray-800 p-4 rounded-lg border-l-4 {{ $borderColor }} mb-6">
                
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-semibold text-lg">Phim: {{ $booking->showtime->phim->ten_phim ?? 'Phim đã bị xóa' }}</h3>
                    
                    {{-- Hiển thị trạng thái --}}
                    <span class="text-xs font-bold bg-gray-700 px-3 py-1 rounded-full">{{ strtoupper($booking->status) }}</span>
                </div>

                <p>Rạp: {{ $booking->showtime->room->theater->name ?? 'N/A' }} - Phòng: {{ $booking->showtime->room->ten_phong ?? 'N/A' }}</p>
                <p>Ngày/Giờ: {{ $booking->showtime->ngay_chieu }} - {{ $booking->showtime->gio_chieu }}</p>

                {{-- Hiển thị số lượng ghế VÀ chi tiết ghế --}}
                <p>Ghế ({{ $booking->so_luong_ghe }}): 
                    @foreach($booking->seats as $seat)
                        <span class="inline-block px-2 py-1 bg-gray-700 rounded mr-1">{{ $seat->hang }}{{ $seat->cot }}</span>
                    @endforeach
                </p>

                <p>Snack: 
                    @forelse($booking->snacks as $snack)
                        <span class="inline-block px-2 py-1 bg-gray-700 rounded mr-1">
                            {{ $snack->ten }} x{{ $snack->pivot->so_luong }}
                        </span>
                    @empty
                        <span class="text-gray-400">Không có snack</span>
                    @endforelse
                </p>

                <p class="font-semibold mt-2">Tổng tiền booking: <span class="text-green-400">{{ number_format($booking->total_price,0,',','.') }}đ</span></p>
                
                <p class="text-xs text-gray-500 mt-2">Ngày đặt: {{ $booking->created_at->format('d/m/Y H:i') }}</p>
            </div>
        @empty
            <p>Bạn chưa đặt booking nào.</p>
        @endforelse
    </div>
</div>
@endsection