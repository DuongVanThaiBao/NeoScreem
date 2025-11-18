@extends('layouts.app')

@section('content')
<div class="bg-gray-900 text-white min-h-screen">
    <div class="container mx-auto p-8">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
            
            <h2 class="text-3xl font-bold text-green-400 mb-4">Đặt vé thành công!</h2>
            
            @if($booking)
                <p class="mb-4">
                    Cảm ơn <strong>{{ $booking->khach_hang ?? 'Quý khách' }}</strong>. Vé của bạn đã được thêm vào giỏ hàng và đang chờ thanh toán.
                </p>

                @if($booking->showtime)
                    <div class="border-t border-gray-700 pt-4 mb-4">
                        <h3 class="text-xl font-semibold mb-2">{{ $booking->showtime->phim->ten_phim ?? 'Không rõ tên phim' }}</h3>
                        <p><strong>Rạp:</strong> {{ $booking->showtime->room->theater->name ?? 'N/A' }}</p>
                        <p><strong>Phòng:</strong> {{ $booking->showtime->room->ten_phong ?? 'N/A' }}</p>
                        <p><strong>Ngày:</strong> {{ \Carbon\Carbon::parse($booking->showtime->ngay_chieu)->format('d/m/Y') }}</p>
                        <p><strong>Giờ:</strong> {{ $booking->showtime->gio_chieu }}</p>
                    </div>
                @endif

                <div class="border-t border-gray-700 pt-4 mb-4">
                    <h4 class="text-lg font-semibold">Ghế đã đặt:</h4>
                    
                    <p class="text-gray-400 text-sm">Tổng số lượng: {{ $booking->so_luong_ghe }} ghế</p>

                    <div class="flex flex-wrap gap-2 mt-2">
                        @forelse($booking->seats as $seat)
                            <span class="bg-blue-500 px-3 py-1 rounded-md text-sm">
                                {{ $seat->hang }}{{ $seat->cot }}
                            </span>
                        @empty
                            <p class="text-gray-400">Không có thông tin ghế.</p>
                        @endforelse
                    </div>
                </div>

                <div class="border-t border-gray-700 pt-4 mb-4">
                    <h4 class="text-lg font-semibold">Snack đã mua:</h4>
                    <ul class="list-disc list-inside mt-2">
                        @forelse($booking->snacks as $snack)
                            <li>
                                {{ $snack->ten }} 
                                (Số lượng: <strong>{{ $snack->pivot->so_luong }}</strong>)
                            </li>
                        @empty
                            <p class="text-gray-400">Không có snack.</p>
                        @endforelse
                    </ul>
                </div>
                
                <div class="border-t border-gray-700 pt-4 mt-6">
                    <h3 class="text-2xl font-bold text-right">
                        Tổng tiền: 
                        <span class="text-green-400">
                            {{ number_format($booking->total_price, 0, ',', '.') }}đ
                        </span>
                    </h3>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-white">← Quay về trang chủ</a>
                    <a href="{{ route('cart') }}" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg font-semibold">
                        Đi đến Giỏ hàng & Thanh toán
                    </a>
                </div>
            
            @else
                <p class="text-red-500">Không tìm thấy thông tin booking.</p>
            @endif
            
        </div>
    </div>

</div>
@endsection