@extends('layouts.app')

@section('content')
<div class="bg-gray-900 text-white min-h-screen">
    <div class="max-w-6xl mx-auto py-12 px-6">

        <h2 class="text-2xl font-semibold mb-4">Chọn ghế cho phim: {{ $phim->ten_phim }}</h2>

        <div class="bg-gray-800 p-4 rounded-lg mb-4">
            {{-- Hiển thị thông tin của 1 suất chiếu duy nhất --}}
            <h3 class="text-xl font-semibold">{{ $showtime->room->theater->name }}</h3>
            <p class="text-gray-400">{{ $showtime->room->theater->location }}</p>

            <div class="mt-2 p-2 bg-gray-700 rounded-md">
                <strong>{{ \Carbon\Carbon::parse($showtime->ngay_chieu)->format('d/m/Y') }} – {{ $showtime->gio_chieu }}</strong>
                – Phòng: {{ $showtime->room->ten_phong }}

                {{-- Form chọn ghế + snack cho suất này --}}
                <form action="{{ route('booking.finalize', $showtime->id) }}" method="POST" class="mt-2 booking-form">
                    @csrf

                    {{-- Sơ đồ ghế --}}
                    <div class="grid gap-2 mb-2">
                        @php
                            $seats = $showtime->room->seats->groupBy('hang');
                            $bookedSeats = $showtime->bookings->flatMap(fn($b) => $b->seats)->pluck('id')->toArray();
                            $giaVe = $showtime->gia_ve;
                        @endphp
                        @foreach($seats as $hang => $row)
                            <div class="flex space-x-2 items-center mb-1">
                                <span class="w-6 font-semibold">{{ $hang }}</span>
                                @foreach($row as $seat)
                                    @php
                                        $isBooked = in_array($seat->id, $bookedSeats);
                                        $color = $isBooked ? 'bg-red-600 cursor-not-allowed' :
                                                 ($seat->loai=='vip' ? 'bg-yellow-500' :
                                                 ($seat->loai=='doi' ? 'bg-pink-500' : 'bg-gray-700'));
                                    @endphp
                                    <label class="cursor-pointer relative">
                                        <input type="checkbox" name="seats[]" value="{{ $seat->id }}" class="hidden seat-checkbox" data-price="{{ $giaVe }}" @if($isBooked) disabled @endif>
                                        <div class="w-10 h-10 flex items-center justify-center rounded-md {{ $color }}">
                                            {{ $seat->cot }}
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    {{-- Snack --}}
                    <div class="mb-2">
                        @foreach($snacks as $snack)
                            <div class="flex items-center justify-between mb-1">
                                <div>{{ $snack->ten }} - {{ number_format($snack->gia,0,',','.') }}đ</div>
                                <input type="number" name="snacks[{{ $snack->id }}]" value="0" min="0" class="w-20 rounded-lg p-1 text-black snack-input" data-price="{{ $snack->gia }}">
                            </div>
                        @endforeach
                    </div>

                    {{-- Tổng tiền --}}
                    <div class="text-lg font-semibold mb-2">
                        Tổng tiền: <span class="text-green-400 total-price">0đ</span>
                    </div>

                    <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg font-semibold">
                        Đặt vé (Chờ thanh toán)
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- JS đổi màu ghế + tính tổng tiền --}}
<script>
// Chỉ có 1 form nên không cần lặp .forEach
const form = document.querySelector('.booking-form');
if (form) {
    const seats = form.querySelectorAll('.seat-checkbox');
    const snacks = form.querySelectorAll('.snack-input');
    const totalEl = form.querySelector('.total-price');

    function updateTotal() {
        let total = 0;

        // Tổng tiền ghế
        seats.forEach(cb => {
            if (cb.checked) {
                total += parseInt(cb.dataset.price);
            }
        });

        // Tổng tiền snack
        snacks.forEach(snack => {
            const qty = parseInt(snack.value) || 0;
            if (qty > 0) {
                total += parseInt(snack.dataset.price) * qty;
            }
        });

        totalEl.textContent = total.toLocaleString('vi-VN') + 'đ';
    }

    // Lắng nghe sự kiện 'change' trên checkbox
    seats.forEach(cb => {
        const seatDiv = cb.nextElementSibling; // div hiển thị ghế

        if (!cb.disabled) {
            cb.addEventListener('change', () => {
                seatDiv.classList.toggle('bg-green-600', cb.checked);
                updateTotal();
            });
        }
    });

    // Snack thay đổi số lượng → cập nhật tổng
    snacks.forEach(snack => {
        snack.addEventListener('input', updateTotal);
    });

    updateTotal(); // Tính tổng lúc đầu
}
</script>
@endsection