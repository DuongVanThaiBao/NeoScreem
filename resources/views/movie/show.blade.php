@extends('layouts.app')

@section('content')
{{-- 
    Tệp này yêu cầu Alpine.js được tải trong layout (layouts.app)
    để phần Lịch Chiếu Động hoạt động.
--}}
<div class="bg-gray-900 text-white min-h-screen">

    {{-- 1. PHẦN BANNER PHIM --}}
    <div class="relative h-[500px]">
        <img src="{{ asset('storage/' . $movie->anh_banner) }}" 
             alt="{{ $movie->ten_phim }} Banner" 
             class="absolute inset-0 w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent"></div>

        <div class="relative z-10 flex items-center h-full max-w-6xl mx-auto px-6">
            <img src="{{ asset('storage/' . $movie->anh_poster) }}" 
                 alt="{{ $movie->ten_phim }} Poster" 
                 class="w-64 rounded-2xl shadow-xl border-4 border-white/20 hidden md:block">

            <div class="md:ml-10 max-w-2xl">
                <h1 class="text-4xl font-bold mb-2">{{ $movie->ten_phim }}</h1>
                <div class="flex items-center text-sm text-gray-300 space-x-3 mb-3">
                    <span>{{ $movie->the_loai }}</span>
                    <span>•</span>
                    <span>{{ $movie->thoi_luong }} phút</span>
                    <span>•</span>
                    {{-- SỬA: Đã bỏ comment và dùng 'do_tuoi' --}}
                    <span class="border border-gray-500 px-1.5 rounded">{{ $movie->do_tuoi }}+</span>
                </div>
                {{-- SỬA: Dùng cột 'mo_ta' (từ Phim.php) --}}
                <p class="text-gray-300 mb-4 text-sm leading-relaxed hidden md:block">
                    {{ Str::limit($movie->mo_ta, 250) }}
                </p>
                <div class="flex items-center space-x-3">
                    <a href="{{ $movie->trailer_url }}" target="_blank" 
                       class="bg-red-600 px-5 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                        Xem trailer
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. PHẦN NỘI DUNG VÀ SUẤT CHIẾU (Bố cục 2 cột) --}}
    <div class="max-w-6xl mx-auto py-12 px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            {{-- CỘT TRÁI: THÔNG TIN CHI TIẾT --}}
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-semibold mb-6 border-b border-gray-700 pb-2">Nội Dung Phim</h2>
                {{-- SỬA: Dùng cột 'mo_ta' (từ Phim.php) --}}
                <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed">
                    <p>{{ $movie->mo_ta }}</p> 
                </div>

                <h2 class="text-2xl font-semibold mt-10 mb-6 border-b border-gray-700 pb-2">Thông Tin Chi Tiết</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-300">
                    <p><strong>Đạo diễn:</strong> {{ $movie->dao_dien }}</p>
                    <p><strong>Diễn viên:</strong> {{ $movie->dien_vien }}</p>
                    <p><strong>Ngôn ngữ:</strong> {{ $movie->ngon_ngu }}</p>
                    {{-- <p><strong>Quốc gia:</strong> {{ $movie->quoc_gia }}</p> --}}
                    {{-- SỬA: Dùng cột 'ngay_chieu' (từ Phim.php) --}}
                    <p><strong>Ngày khởi chiếu:</strong> {{ \Carbon\Carbon::parse($movie->ngay_chieu)->format('d/m/Y') }}</p>
                    {{-- <p><strong>Ngày kết thúc:</strong> {{ \Carbon\Carbon::parse($movie->ngay_ket_thuc)->format('d/m/Y') }}</p> --}}
                </div>
            </div>

            {{-- CỘT PHẢI: SUẤT CHIẾU (ĐỘNG VỚI ALPINE.JS) --}}
            <div class="lg:col-span-1">
    
                {{-- Kiểm tra xem $dates có rỗng không --}}
                @if ($dates->isNotEmpty())
                    
                    {{-- THAY ĐỔI: Thêm 'openCinemaId' để quản lý accordion --}}
                    {{-- Mặc định mở rạp đầu tiên trong danh sách --}}
                    <div x-data="{ 
                            selectedDate: '{{ $dates->first()['value'] }}',
                            openCinemaId: {{ $allCinemas->first()->id ?? 'null' }}, 
                            showtimesData: {!! json_encode($showtimesByDate->toArray(), JSON_UNESCAPED_UNICODE) !!}
                         }">
            
                        <h2 class="text-2xl font-semibold mb-6 border-b border-gray-700 pb-2">Lịch Chiếu</h2>
            
                        {{-- Bộ lọc Ngày (Tab) --}}
                        <div class="grid grid-cols-4 gap-2 mb-6">
                            @foreach ($dates as $date)
                                <button 
                                    {{-- THAY ĐỔI: Khi đổi ngày, reset rạp đang mở --}}
                                    @click="selectedDate = '{{ $date['value'] }}'; openCinemaId = null"
                                    :class="{
                                        'bg-yellow-400 text-gray-900 shadow-lg scale-105': selectedDate === '{{ $date['value'] }}',
                                        'bg-gray-800 text-white hover:bg-gray-700 border border-gray-700': selectedDate !== '{{ $date['value'] }}'
                                    }"
                                    class="text-center rounded-lg p-2 transition-all duration-300"
                                    style="min-height: 70px;"
                                >
                                    <div class="text-sm font-bold">{{ $date['day_of_week_short'] }}</div>
                                    <div class="font-bold text-lg">{{ $date['day_month'] }}</div>
                                </button>
                            @endforeach
                        </div>
            
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-2xl font-semibold">Danh Sách Rạp</h2>
                            <button class="border border-yellow-400 text-yellow-400 px-3 py-1 rounded text-sm font-semibold">
                                TP. HỒ CHÍ MINH
                            </button>
                        </div>
                        
                        {{-- Danh sách Rạp (Hiển thị động) --}}
                        <div class="space-y-4">
            
                            @forelse ($allCinemas as $cinema)
                                <div x-data="{
                                        get cinemaShowtimes() {
                                            return this.showtimesData[this.selectedDate] ? (this.showtimesData[this.selectedDate][{{ $cinema->id }}] || null) : null
                                        }
                                     }"
                                     class="bg-gray-800 rounded-lg border border-gray-700 transition-all duration-300"
                                     {{-- THAY ĐỔI: Thêm class viền vàng nếu đang mở --}}
                                     :class="{ 'border-yellow-500': openCinemaId === {{ $cinema->id }} }"
                                     x-show="cinemaShowtimes" 
                                     x-transition> 
            
                                    {{-- Tên rạp và địa chỉ (Click để Mở/Đóng) --}}
                                    {{-- THAY ĐỔI: Thêm @click --}}
                                    <div class="flex justify-between items-center p-4 cursor-pointer"
                                         @click="openCinemaId = (openCinemaId === {{ $cinema->id }} ? null : {{ $cinema->id }})">
                                        <div>
                                            <h3 class="font-semibold text-yellow-400 text-lg">{{ $cinema->ten_rap }}</h3>
                                            <p class="text-sm text-gray-400">{{ $cinema->dia_chi }}</p>
                                        </div>
                                        {{-- THAY ĐỔI: Icon mũi tên (chevron) và hiệu ứng xoay --}}
                                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" 
                                             :class="{ 'rotate-180': openCinemaId === {{ $cinema->id }} }"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
            
                                    {{-- Hộp chứa các suất chiếu (Lấy từ Alpine.js) --}}
                                    {{-- THAY ĐỔI: Thêm x-show và x-transition để Mở/Đóng --}}
                                    <div classD="border-t border-gray-700 p-4" 
                                         x-show="openCinemaId === {{ $cinema->id }}" 
                                         x-transition>
                                        
                                        {{-- Hiển thị Định dạng (Standard/2D) --}}
                                        <div x-if="cinemaShowtimes">
                                            {{-- Giả sử định dạng là giống nhau cho 1 rạp, 1 ngày --}}
                                            <span class="text-sm font-semibold text-yellow-400 mb-2 block" 
                                                  x-text="cinemaShowtimes.times[0].dinh_dang">
                                                Standard
                                            </span>
                                        </div>

                                        {{-- Hiển thị các Giờ chiếu --}}
                                        <div x-if="cinemaShowtimes" class="flex flex-wrap gap-2">
                                            <template x-for="showtime in cinemaShowtimes.times" :key="showtime.id">
                                                <a :href="`/booking/${showtime.id}`"
                                                   class="border border-gray-600 text-white text-center rounded-lg overflow-hidden w-24
                                                          transition-all duration-300 transform hover:scale-105 hover:border-yellow-400 hover:shadow-lg">
                                                    
                                                    {{-- SỬA: Dùng cột 'gio_chieu' (từ Showtime.php) --}}
                                                    <div class="font-bold text-lg py-2 px-1" 
                                                         x-text="new Date('1970-01-01T' + showtime.gio_chieu).toLocaleTimeString('vi-VN', {hour: '2-digit', minute:'2-digit'})">
                                                    </div>

                                                    {{-- Giá vé --}}
                                                    <div class="bg-gray-700 text-yellow-400 text-xs font-semibold py-1 px-1 border-t border-gray-600">
                                                        <span x-text="new Intl.NumberFormat('vi-VN').format(showtime.gia_ve) + 'đ'"></span>
                                                    </div>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-gray-800 rounded-lg p-6 text-center text-gray-400 border border-gray-700">
                                    <p>Không có rạp nào đang chiếu phim này.</p>
                                </div>
                            @endforelse
            
                            {{-- Thông báo nếu không có suất chiếu CHO NGÀY ĐƯỢC CHỌN --}}
                            <div x-show="!Object.keys(showtimesData[selectedDate] || {}).length"
                                 class="bg-gray-800 rounded-lg p-6 text-center text-gray-400 border border-gray-700"
                                 style="display: none;"> {{-- Ẩn ban đầu --}}
                                <p>Không có suất chiếu cho ngày này.</p>
                            </div>
                        </div>
                    </div>
                
                @else
                    {{-- Thông báo nếu $dates rỗng (tức là không có suất chiếu nào) --}}
                    <h2 class="text-2xl font-semibold mb-6 border-b border-gray-700 pb-2">Lịch Chiếu</h2>
                    <div class="bg-gray-800 rounded-lg p-6 text-center text-gray-400 border border-gray-700">
                        <p>Hiện chưa có suất chiếu nào cho phim này.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

</div>
@endsection