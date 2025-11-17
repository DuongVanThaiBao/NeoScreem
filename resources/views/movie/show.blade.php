@extends('layouts.app')

@section('content')
<div class="bg-gray-900 text-white min-h-screen">

    {{-- BANNER + POSTER --}}
    <div class="relative h-[500px]">
        <img src="{{ asset('storage/' . $phim->anh_banner) }}" 
             alt="{{ $phim->ten_phim }} Banner" 
             class="absolute inset-0 w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent"></div>

        <div class="relative z-10 flex items-center h-full max-w-6xl mx-auto px-6">
            <img src="{{ asset('storage/' . $phim->anh_poster) }}" 
                 alt="{{ $phim->ten_phim }} Poster" 
                 class="w-64 rounded-2xl shadow-xl border-4 border-white/20 hidden md:block">

            <div class="md:ml-10 max-w-2xl">
                <h1 class="text-4xl font-bold mb-2">{{ $phim->ten_phim }}</h1>
                <div class="flex items-center text-sm text-gray-300 space-x-3 mb-3">
                    <span>{{ $phim->the_loai }}</span>
                    <span>•</span>
                    <span>{{ $phim->thoi_luong }} phút</span>
                    <span>•</span>
                    <span class="border border-gray-500 px-1.5 rounded">{{ $phim->do_tuoi }}+</span>
                </div>
                <p class="text-gray-300 mb-4 text-sm leading-relaxed hidden md:block">
                    {{ Str::limit($phim->mo_ta, 250) }}
                </p>
                <div class="flex items-center space-x-3">
                    <a href="{{ $phim->trailer_url }}" target="_blank" 
                       class="bg-red-600 px-5 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                        Xem trailer
                    </a>

                    {{-- Nút đặt vé --}}
                    @if($phim->showtimes->count())
                        <a href="{{ route('booking.show', $phim->id) }}" 
                           class="bg-green-600 px-5 py-2 rounded-lg hover:bg-green-700 transition font-semibold">
                            Đặt vé
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- NỘI DUNG PHIM --}}
    <div class="max-w-6xl mx-auto py-12 px-6">
        <h2 class="text-2xl font-semibold mb-6 border-b border-gray-700 pb-2">Nội Dung Phim</h2>
        <p class="text-gray-300 leading-relaxed mb-6">{{ $phim->mo_ta }}</p>

        <h3 class="text-xl font-bold mb-4">Thông tin chi tiết</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-300">
            <p><strong>Đạo diễn:</strong> {{ $phim->dao_dien }}</p>
            <p><strong>Diễn viên:</strong> {{ $phim->dien_vien }}</p>
            <p><strong>Ngôn ngữ:</strong> {{ $phim->ngon_ngu }}</p>
            <p><strong>Ngày khởi chiếu:</strong> {{ \Carbon\Carbon::parse($phim->ngay_chieu)->format('d/m/Y') }}</p>
        </div>
    </div>

</div>
@endsection
