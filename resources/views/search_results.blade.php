@extends('layouts.app') {{-- Kế thừa file layout chính --}}

@section('title', 'Kết quả tìm kiếm cho "' . e($keyword ?? '') . '"') {{-- e() để tránh XSS --}}

@section('content')
<div class="container mx-auto px-4 py-12 md:py-16">

    {{-- 1. Ô Tìm Kiếm --}}
    <div class="mb-10 md:mb-12">
        <form action="{{ route('movie.search') }}" method="GET" class="max-w-xl mx-auto">
            <label class="relative block">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input 
                    name="keyword" 
                    value="{{ e($keyword ?? '') }}" {{-- e() để tránh XSS --}}
                    class="form-input w-full rounded-full text-white focus:outline-none focus:ring-2 focus:ring-primary border-gray-700 bg-gray-800 focus:border-primary h-12 placeholder:text-gray-500 px-4 pl-12 text-sm font-normal" 
                    placeholder="Nhập tên phim bạn muốn tìm..." 
                    type="search" 
                    required
                />
            </label>
        </form>
    </div>

    <hr class="border-gray-800 my-8 md:my-10">

    {{-- 2. Tiêu đề Kết Quả --}}
    @if (!empty($keyword))
        <h2 class="text-xl md:text-2xl font-semibold text-gray-200 mb-8 text-center md:text-left">
            Kết quả tìm kiếm cho: "<span class="text-primary font-bold">{{ e($keyword) }}</span>"
        </h2>
    @endif

    {{-- 3. Lưới Hiển Thị Kết Quả --}}
    @if ($results->isNotEmpty())
        {{-- CONTAINER GRID CHÍNH --}}
         <div id="phim-dang-chieu" class="hide-scrollbar tab-content mt-5 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 p-2">
            
            @foreach($results as $phim)
                {{-- THẺ PHIM (KHÔNG CÓ w-* hoặc flex-shrink-0) --}}
                <div class="atropos group relative flex flex-col h-full cursor-pointer bg-gray-800/50 rounded-lg overflow-hidden shadow-lg transition-transform duration-300 hover:-translate-y-1">                                        
                                        {{-- Phần atropos scale --}}
                                          <div class="atropos-scale">
                                    <div class="atropos-rotate">
                                        <div class="atropos-inner rounded-lg overflow-hidden relative">

                                            <!-- Poster phim -->
                                            <img data-atropos-offset="-5"
                                                src="{{ asset('storage/' . $phim->anh_poster) }}"
                                                alt="{{ $phim->ten_phim }}"
                                                class="w-full h-full object-cover aspect-[2/3] transition-transform duration-500 group-hover:scale-110">

                                            <!-- Overlay khi hover -->
                                            <div data-atropos-offset="0" 
                                                class="absolute inset-0 flex flex-col items-center justify-center bg-slate-900/85 text-center text-white opacity-0 transition-opacity duration-500 group-hover:opacity-100 sm:p-4">

                                                <h3 class="mb-4 font-bold text-base sm:text-lg line-clamp-2">{{ $phim->ten_phim }}</h3>
                                                
                                                <ul class="space-y-2 text-xs sm:text-sm">
                                                    <li><i class="fa-solid fa-users text-yellow-400"></i> {{ $phim->the_loai ?? 'Đang cập nhật' }}</li>
                                                    <li><i class="fa-solid fa-clock text-yellow-400"></i> {{ $phim->thoi_luong ?? 'N/A' }} phút</li>
                                                    <li><i class="fa-solid fa-globe-asia text-yellow-400"></i> {{ $phim->quoc_gia ?? 'N/A' }}</li>
                                                    <li><i class="fa-solid fa-comment-dots text-yellow-400"></i> {{ $phim->ngon_ngu ?? 'N/A' }}</li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                       <div class="p-3 text-center bg-gray-900">
                                    <p class="text-xs text-gray-400">
                                        Khởi chiếu: 
                                        {{ $phim->ngay_khoi_chieu ? \Carbon\Carbon::parse($phim->ngay_khoi_chieu)->format('d/m/Y') : 'N/A' }}
                                    </p>
                                    <h3 class="mt-1 font-bold text-white text-base leading-tight line-clamp-2">
                                        <a href="#" class="hover:text-yellow-400 transition-colors">
                                            {{ $phim->ten_phim }}
                                        </a>
                                    </h3>
                                    <div class="mt-2 flex justify-center gap-3">
                                        <button class="trailer-btn flex items-center gap-2 text-sm text-gray-300 hover:text-white" 
                                                data-trailer-id="{{ $phim->trailer_id ?? '' }}">
                                            <i class="fa-solid fa-play text-yellow-400"></i> Trailer
                                        </button>
                                        <a href="#" class="rounded bg-yellow-400 px-3 py-1 text-xs font-bold text-black hover:bg-yellow-500">
                                            TÌM HIỂU THÊM
                                        </a>
                                    </div>
                                </div>
                                    </div>
                {{-- KẾT THÚC THẺ PHIM --}}
            @endforeach
        </div>

        {{-- 4. Phân Trang --}}
        <div class="mt-12">
            {{ $results->appends(['keyword' => $keyword])->links() }} 
        </div>

    {{-- 5. Thông Báo Không Có Kết Quả --}}
    @elseif (!empty($keyword)) 
        <div class="text-center py-16">
            <i class="fa-solid fa-film text-6xl text-gray-600 mb-4"></i>
            <p class="text-gray-400 text-lg">Rất tiếc, không tìm thấy phim nào phù hợp với từ khóa "<span class="text-primary font-semibold">{{ e($keyword) }}</span>".</p>
            <p class="text-gray-500 mt-2">Vui lòng thử tìm kiếm với từ khóa khác.</p>
        </div>
    @endif

</div>

{{-- Script khởi tạo Atropos --}}
@push('scripts') 
<script src="https://cdn.jsdelivr.net/npm/atropos@2/atropos.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const initAtropos = () => {
             if (typeof Atropos === 'undefined') return;
             document.querySelectorAll('.atropos').forEach(element => {
                 if (!element.atropos) { Atropos({ el: element }); }
             });
        }
        initAtropos(); 
        
        // Cần lắng nghe sự kiện khi trang phân trang được tải lại bằng AJAX (nếu dùng)
        // Nếu dùng phân trang thông thường (tải lại cả trang) thì không cần thêm gì.
    });
</script>
@endpush

@endsection