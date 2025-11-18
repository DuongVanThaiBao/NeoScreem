@extends('layouts.app')

@section('content')
<div class="bg-gray-900 text-white min-h-screen">
    <div class="max-w-5xl mx-auto py-12 px-6">
        <h2 class="text-2xl font-semibold mb-6">Giỏ hàng (Các vé chờ thanh toán)</h2>

        @if($bookings->isEmpty())
            <p>Chưa có booking nào trong giỏ hàng.</p>
        @else
            {{-- Form này trỏ đến route 'cart.checkout' là ĐÚNG --}}
            <form action="{{ route('cart.checkout') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    @foreach($bookings as $booking)
                        <div class="bg-gray-800 p-4 rounded-lg">
                            
                            {{-- Đã sửa: 'ten' -> 'ten_phim' --}}
                            <h3 class="font-semibold">Phim: {{ $booking->showtime->phim->ten_phim ?? 'Phim đã bị xóa' }}</h3>
                            
                            <p>Rạp: {{ $booking->showtime->room->theater->name }} - Phòng: {{ $booking->showtime->room->ten_phong }}</p>
                            <p>Ngày/Giờ: {{ $booking->showtime->ngay_chieu }} - {{ $booking->showtime->gio_chieu }}</p>

                            {{-- Đã sửa: Thêm vòng lặp ghế --}}
                            <p>Ghế ({{ $booking->so_luong_ghe }}): 
                                @foreach($booking->seats as $seat)
                                    <span class="inline-block px-2 py-1 bg-gray-700 rounded mr-1">{{ $seat->hang }}{{ $seat->cot }}</span>
                                @endforeach
                            </p>

                            <p>Snack: 
                                @forelse($booking->snacks as $snack)
                                    <span class="inline-block px-2 py-1 bg-yellow-500 text-black rounded mr-1">
                                        {{ $snack->ten }} x{{ $snack->pivot->so_luong }}
                                    </span>
                                @empty
                                    <span class="text-gray-400">Không có snack</span>
                                @endforelse
                            </p>

                            {{-- Đã sửa: 'tong_tien' -> 'total_price' --}}
                            <p class="font-semibold">Tổng tiền booking: <span class="text-green-400">{{ number_format($booking->total_price,0,',','.') }}đ</span></p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 text-xl font-bold">
                    Tổng thanh toán: <span class="text-green-400">{{ number_format($totalAll,0,',','.') }}đ</span>
                </div>

                <button type="submit" class="mt-4 bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg font-semibold">
                    Thanh toán tất cả
                </button>
            </form>
        @endif
    </div>
</div>
@endsection