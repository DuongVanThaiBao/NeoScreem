<!DOCTYPE html>
<html class="dark scroll-smooth" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>NeoScreem - Your Ultimate Cinema Experience</title>
    <meta name="description" content="Book movie tickets online at NeoScreem. Discover the latest movies, showtimes, and promotions at our cinemas. Your ultimate cinema experience starts here."/>
    
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/atropos@2/atropos.min.css" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="https://unpkg.com/atropos/css" />
    <script src="https://unpkg.com/atropos"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#ea2a33",
                        "background-light": "#f8f6f6",
                        "background-dark": "#121212", 
                    },
                    fontFamily: {
                        display: ["Plus Jakarta Sans", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.375rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px",
                    },
                },
            },
        };
    </script>
    <style>
        .hide-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .scroll-container { -ms-overflow-style: none; scrollbar-width: none; }
        .scroll-container::-webkit-scrollbar { display: none; }
        #banner-slider { transition: background-image 0.5s ease-in-out; }
        #mobile-menu { transition: transform 0.3s ease-in-out; }
        .fade-in-section { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
        .fade-in-section.is-visible { opacity: 1; transform: translateY(0); }
        #phim-dang-chieu, #phim-sap-chieu { transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out; }
        /* SỬA LẠI: .tab-content khi ẩn đi */
        .tab-content.hidden { opacity: 0; transform: scale(0.98); display: none !important; }
        .tab-content { display: grid; } /* Mặc định là grid */
        .btn-glow:hover { box-shadow: 0 0 15px 0 rgba(234, 42, 51, 0.6); }
        .animated-gradient { background-size: 200% 200%; animation: gradient-animation 10s ease infinite; }
        @keyframes gradient-animation { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
        .atropos {
            position: relative !important;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200">
    <div class="flex min-h-screen w-full flex-col">
        
        {{-- HEADER (Giữ nguyên - Không có lỗi) --}}
        <header class="sticky top-0 z-50 border-b border-gray-200/10 dark:border-gray-800/10 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm">
            <div class="container mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center gap-8">
                    <a class="flex items-center gap-3 text-gray-900 dark:text-white" href="#">
                        <svg class="h-8 w-8 text-primary " fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="M24 18.4228L42 11.475V34.3663C42 34.7796 41.7457 35.1504 41.3601 35.2992L24 42V18.4228Z" fill="currentColor" fill-rule="evenodd"></path><path clip-rule="evenodd" d="M24 8.18819L33.4123 11.574L24 15.2071L14.5877 11.574L24 8.18819ZM9 15.8487L21 20.4805V37.6263L9 32.9945V15.8487ZM27 37.6263V20.4805L39 15.8487V32.9945L27 37.6263ZM25.354 2.29885C24.4788 1.98402 23.5212 1.98402 22.646 2.29885L4.98454 8.65208C3.7939 9.08038 3 10.2097 3 11.475V34.3663C3 36.0196 4.01719 37.5026 5.55962 38.098L22.9197 44.7987C23.6149 45.0671 24.3851 45.0671 25.0803 44.7987L42.4404 38.098C43.9828 37.5026 45 36.0196 45 34.3663V11.475C45 10.2097 44.2061 9.08038 43.0155 8.65208L25.354 2.29885Z" fill="currentColor" fill-rule="evenodd"></path></svg>
                        <h1 class="text-xl font-bold">NeoScreem</h1>
                    </a>
                    <nav id="desktop-nav" class="hidden lg:flex items-center gap-8">
                        <a class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Movies</a>
                        <a class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Cinema Cluster</a>
                        <a class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Members</a>
                        <a class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Promotions</a>
                    </nav>
                </div>
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center">
                        <label class="relative"><span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 dark:text-gray-500"><svg fill="currentColor" height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path></svg></span><input class="form-input w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 focus:border-primary h-10 placeholder:text-gray-400 dark:placeholder:text-gray-500 px-4 pl-10 text-sm font-normal" placeholder="Search movies..." type="search" /></label>
                    </div>
                    
                    <div class="hidden lg:flex items-center">
                        @auth
                            {{-- Nếu đã đăng nhập --}}
                            <div class="relative ml-4">
                                <div>
                                    <button type="button" class="flex max-w-xs items-center rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-background-dark" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        <span class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 256 256"><path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.79,40.31,185.67,25.08,212a8,8,0,0,0,13.84,8c18.1-31.33,50.62-52,89.08-52s71,20.67,89.08,52a8,8,0,0,0,13.84-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path></svg>
                                        </span>
                                        <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 hidden md:block">{{ Auth::user()->name }}</span>
                                        <svg class="ml-1 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </button>
                                </div>
                                
                                <div id="user-menu" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-800 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem" tabindex="-1">Hồ sơ cá nhân</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem" tabindex="-1">Giỏ hàng</a>
                                    <form action="{{ route('logout') }}" method="POST" role="none">
                                        @csrf
                                        <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem" tabindex="-1">
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            {{-- Nếu chưa đăng nhập --}}
                            <div class="flex items-center gap-2 ml-4">
                                <a href="{{ route('login') }}" class="rounded-md px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">Đăng nhập</a>
                                <a href="{{ route('register') }}" class="rounded-md bg-primary px-4 py-2 text-sm font-bold text-white hover:bg-primary/90 transition-colors btn-glow">Đăng ký</a>
                            </div>
                        @endauth
                    </div>
                    <button id="mobile-menu-button" class="lg:hidden text-gray-900 dark:text-white"><svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M224,128a8,8,0,0,1-8,8H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,128ZM40,88H216a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16ZM216,184H40a8,8,0,0,0,0-16H216a8,8,0,0,0,0,16Z"></path></svg></button>
                </div>
            </div>
        </header>

        {{-- MOBILE MENU (Giữ nguyên - Không có lỗi) --}}
        <div id="mobile-menu" class="fixed inset-0 z-[100] bg-background-light dark:bg-background-dark transform -translate-y-full transition-transform duration-300 ease-in-out lg:hidden">
            <div class="container mx-auto flex h-full flex-col p-4">
                <div class="flex items-center justify-between mb-8">
                     <a class="flex items-center gap-3 text-gray-900 dark:text-white" href="#">
                         <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path clip-rule="evenodd" d="M24 18.4228L42 11.475V34.3663C42 34.7796 41.7457 35.1504 41.3601 35.2992L24 42V18.4228Z" fill="currentColor" fill-rule="evenodd"></path><path clip-rule="evenodd" d="M24 8.18819L33.4123 11.574L24 15.2071L14.5877 11.574L24 8.18819ZM9 15.8487L21 20.4805V37.6263L9 32.9945V15.8487ZM27 37.6263V20.4805L39 15.8487V32.9945L27 37.6263ZM25.354 2.29885C24.4788 1.98402 23.5212 1.98402 22.646 2.29885L4.98454 8.65208C3.7939 9.08038 3 10.2097 3 11.475V34.3663C3 36.0196 4.01719 37.5026 5.55962 38.098L22.9197 44.7987C23.6149 45.0671 24.3851 45.0671 25.0803 44.7987L42.4404 38.098C43.9828 37.5026 45 36.0196 45 34.3663V11.475C45 10.2097 44.2061 9.08038 43.0155 8.65208L25.354 2.29885Z" fill="currentColor" fill-rule="evenodd"></path></svg>
                         <h1 class="text-xl font-bold">NeoScreem</h1>
                     </a>
                     <button id="mobile-menu-close-button" class="text-gray-900 dark:text-white">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                         </svg>
                     </button>
                </div>
                <div class="flex flex-col justify-between flex-grow pb-8">
                    <nav class="flex flex-col items-center gap-8 text-2xl">
                        <a class="font-medium text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Movies</a>
                        <a class="font-medium text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Cinema Cluster</a>
                        <a class="font-medium text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Members</a>
                        <a class="font-medium text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors" href="#">Promotions</a>
                    </nav>

                    <div class="flex flex-col gap-4 items-center w-full">
                        <label class="relative w-full"><span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 dark:text-gray-500"><svg fill="currentColor" height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path></svg></span><input class="form-input w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-gray-900 dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 focus:border-primary h-12 placeholder:text-gray-400 dark:placeholder:text-gray-500 px-4 pl-10 text-sm font-normal" placeholder="Search movies..." type="search" /></label>
                        
                        @auth
                            <div class="w-full text-center mt-4">
                                <p class="text-lg font-medium text-gray-800 dark:text-gray-200">Xin chào, {{ Auth::user()->name }}</p>
                                <div class="mt-4 flex flex-col gap-3">
                                    <a href="#" class="w-full text-center rounded-lg h-12 flex items-center justify-center px-4 bg-gray-200 dark:bg-gray-700 text-sm font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">Hồ sơ cá nhân</a>
                                    <a href="#" class="w-full text-center rounded-lg h-12 flex items-center justify-center px-4 bg-gray-200 dark:bg-gray-700 text-sm font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">Giỏ hàng</a>
                                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full rounded-lg h-12 px-4 bg-red-600/20 text-red-600 dark:text-red-500 text-sm font-bold hover:bg-red-600/30 transition-colors">Đăng xuất</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="w-full flex items-center justify-center overflow-hidden rounded-lg h-12 px-4 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-colors btn-glow"><span class="truncate">Đăng ký hoặc Đăng nhập</span></a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        <main>
            {{-- HERO BANNER (Giữ nguyên) --}}
            
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                
                {{-- BOOKING FORM (Giữ nguyên) --}}
                
                <section class="mb-12 fade-in-section">
    {{-- Tiêu đề cho khu vực khuyến mãi --}}
                    <div class="border-b border-gray-800 mb-6">
                        <nav class="flex justify-center">
                            <h2 class="pb-2 border-b-2 text-primary border-primary font-bold transition-colors duration-200 text-2xl md:text-3xl uppercase tracking-wider">
                                Promotions & Events
                            </h2>
                        </nav>
                    </div>

    {{-- 
      THAY ĐỔI: 
      - Đã bỏ: "relative group" (vì không cần nút)
      - Đã bỏ: Các nút <button id="promo-scroll-left/right">
      - Đã đổi container từ "flex overflow-x-auto" thành "grid" với 3 cột (lg:grid-cols-3)
    --}}
                    <div id="promotions-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        
                        @forelse($promotions as $promo)
                            {{-- 
                            THAY ĐỔI: 
                            - Đã bỏ: div bọc ngoài "flex-shrink-0 w-80"
                            - Thêm: "h-full flex flex-col" để các thẻ trong lưới cao bằng nhau.
                            --}}
                            <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden group w-full h-full flex flex-col">
                                <a href="">
                                <div class="atropos">
                                    <div class="atropos-scale">
                                        <div class="atropos-rotate">
                                            <div class="atropos-inner">
                                                <div class="relative">
                                                    <img data-atropos-offset="0" alt="{{ $promo->ten_khuyen_mai }}" 
                                                        class="w-full h-48 object-cover"
                                                        src="{{ asset('storage/' . $promo->anh_banner) }}" />
                                                    
                                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                                    <h3 data-atropos-offset="3" class="absolute bottom-2 left-4 font-bold text-white text-lg truncate w-11/12">
                                                        {{ $promo->ten_khuyen_mai }}
                                                    </h3>
                                                    <div data-atropos-offset="4" class="absolute top-2 right-2">
                                                        @if($promo->so_tien_giam_gia)
                                                            <span class="bg-yellow-400 text-black text-xs font-bold px-3 py-1 rounded-full">
                                                                GIẢM {{ number_format($promo->so_tien_giam_gia, 0, ',', '.') }}K
                                                            </span>
                                                        @elseif($promo->phan_tram_giam_gia)
                                                            <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                                                GIẢM {{ $promo->phan_tram_giam_gia }}%
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    </div>
                                </div>
                                
                                {{-- 
                                THAY ĐỔI: 
                                - Thêm: "flex flex-col flex-grow" để đẩy nội dung bên dưới (nút) xuống đáy thẻ.
                                - Thay "h-16" cố định bằng "line-clamp-3 min-h-[4.5rem]" để linh hoạt hơn.
                                --}}
                                <div class="p-4 flex flex-col flex-grow">
                                    <p class="text-gray-400 text-sm line-clamp-3 min-h-[4.5rem]">
                                        {{ Str::limit(strip_tags($promo->mo_ta ?? ''), 100) }}
                                    </p>
                                    
                                    {{-- Thêm mt-auto để đẩy khối này xuống dưới cùng --}}
                                    <div class="mt-auto pt-4 border-t border-gray-700/50 flex justify-between items-center">
                                        <span class="text-xs text-gray-500">
                                            Hạn: {{ $promo->ngay_ket_thuc ? $promo->ngay_ket_thuc->format('d/m/Y') : 'N/A' }}
                                        </span>
                                        <a href="#" class="rounded bg-yellow-400 px-3 py-1 text-xs font-bold text-black hover:bg-yellow-500 transition-colors">
                                            TÌM HIỂU THÊM
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-white w-full text-center md:col-span-2 lg:col-span-3">Hiện chưa có khuyến mãi nào.</p>
                        @endforelse
                    </div>
                </section>
                @guest
                <section class="mb-12 fade-in-section">
                    <div class="bg-gradient-to-r from-primary via-red-600 to-red-800 dark:from-primary dark:to-red-900 rounded-xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 animated-gradient">
                        <div class="text-white text-center md:text-left">
                            <h2 class="text-3xl font-bold">Become a NeoScreem Member!</h2>
                            <p class="mt-2 opacity-80">Earn points, get exclusive discounts, and enjoy special birthday offers. Join now for free!</p>
                        </div>
                        <form action="{{ route('login') }}" method="GET">
                            <button type="submit"
                                class="flex-shrink-0 min-w-[150px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-6 bg-white text-primary text-sm font-bold hover:bg-gray-200 transition-colors">
                                Sign Up Now
                            </button>
                        </form>
                    </div>
                </section>
                @endguest

            </div> </main>
    </div>

    <button id="back-to-top" class="fixed bottom-5 right-5 z-50 p-3 rounded-full bg-primary text-white shadow-lg hover:bg-primary/90 transition-opacity duration-300 opacity-0 btn-glow">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    </button>
    <script src="https://cdn.jsdelivr.net/npm/atropos@2/atropos.min.js"></script>

    <script>
    // SỬA LỖI: Bọc tất cả code trong DOMContentLoaded để đảm bảo HTML đã tải xong
    // và sửa lỗi cú pháp '});' thừa ở cuối file
    document.addEventListener('DOMContentLoaded', () => {
    
        // --- MOBILE MENU ---
        const mobileMenuBtn = document.getElementById('mobile-menu-button');
        const mobileMenuCloseBtn = document.getElementById('mobile-menu-close-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuBtn && mobileMenu)
            mobileMenuBtn.addEventListener('click', () => mobileMenu.classList.remove('-translate-y-full'));
        if (mobileMenuCloseBtn && mobileMenu)
            mobileMenuCloseBtn.addEventListener('click', () => mobileMenu.classList.add('-translate-y-full'));

        // --- BACK TO TOP BUTTON ---
        const backToTopBtn = document.getElementById('back-to-top');
        if (backToTopBtn) {
            window.addEventListener('scroll', () => {
                backToTopBtn.classList.toggle('opacity-0', window.scrollY <= 300);
            });
            backToTopBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        }

        // --- SCROLL ANIMATION ---
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('is-visible');
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.fade-in-section').forEach(section => observer.observe(section));
        }

        // --- PARALLAX ---
        // SỬA LỖI: Khai báo biến 'banner'
        const banner = document.getElementById('banner-slider');
        window.addEventListener('scroll', () => {
            if (banner) banner.style.backgroundPositionY = window.pageYOffset * 0.7 + 'px';
        });

        // --- USER MENU ---
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        if (userMenuButton && userMenu) {
            userMenuButton.addEventListener('click', () => {
                const isExpanded = userMenuButton.getAttribute('aria-expanded') === 'true';
                userMenuButton.setAttribute('aria-expanded', !isExpanded);
                userMenu.classList.toggle('hidden');
            });
            document.addEventListener('click', (event) => {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenuButton.setAttribute('aria-expanded', 'false');
                    userMenu.classList.add('hidden');
                }
            });
        }

        // --- ATROPOS ---
        const initAtropos = () => {
            if (typeof Atropos === 'undefined') return;
            document.querySelectorAll('.atropos').forEach(element => {
                if (!element.atropos) {
                    Atropos({
                        el: element,
                        activeOffset: 40,
                        shadowScale: 1.05,
                        shadow: false,
                    });
                }
            });
        };
        initAtropos();

        // --- TAB ---
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetTabId = button.dataset.tab;
                tabButtons.forEach(btn => {
                    btn.classList.remove('text-primary', 'border-primary');
                    btn.classList.add('text-gray-400', 'border-transparent');
                });
                button.classList.add('text-primary', 'border-primary');
                button.classList.remove('text-gray-400', 'border-transparent');
                
                // Sửa lỗi: Phải thêm !important vào .hidden mới hoạt động
                tabContents.forEach(content => {
                    content.classList.toggle('hidden', content.id !== targetTabId);
                });
                
                setTimeout(initAtropos, 50);
            });
        });

        // --- PROMOTIONS SLIDER ---
        const promoContainer = document.getElementById('promotions-container');
        const scrollLeftBtn = document.getElementById('promo-scroll-left');
        const scrollRightBtn = document.getElementById('promo-scroll-right');
        if (promoContainer && scrollLeftBtn && scrollRightBtn) {
            const promoItem = promoContainer.querySelector('.flex-shrink-0');
            if (promoItem) {
                // Sửa: Lấy `scrollWidth` của item + gap (32px / 2rem)
                const scrollAmount = promoItem.offsetWidth + 32; 
                scrollLeftBtn.addEventListener('click', () => promoContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' }));
                scrollRightBtn.addEventListener('click', () => promoContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' }));
            }
        }
    }); // <-- Kết thúc của DOMContentLoaded
    </script>
</body>
</html>