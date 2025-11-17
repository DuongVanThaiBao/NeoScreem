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
            /* Dành cho Firefox */
            scrollbar-width: none;
            /* Dành cho Internet Explorer và Edge cũ */
            -ms-overflow-style: none;
            }

            /* Dành cho Chrome, Safari và các trình duyệt WebKit khác */
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
        .tab-content.hidden { opacity: 0; transform: scale(0.98); display: none; }
        .tab-content { display: grid; }
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
        <header class="sticky top-0 z-50 border-b border-gray-200/10 dark:border-gray-800/10 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm">
            <div class="container mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center gap-8">
                    <a class="flex items-center gap-3 text-gray-900 dark:text-white" href="{{ route('home') }}">
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
                                {{-- Form trỏ đến route 'movie.search' bằng phương thức GET --}}
                                <form action="{{ route('movie.search') }}" method="GET" class="relative"> 
                                    <label class="relative">
                                        {{-- Icon tìm kiếm --}}
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                            <svg fill="currentColor" height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"></path></svg>
                                        </span>
                                        {{-- Ô nhập liệu với name="keyword" --}}
                                        <input 
                                            name="keyword" 
                                            class="form-input w-full rounded-lg text-white focus:outline-0 focus:ring-2 focus:ring-primary border-gray-700 bg-gray-800 focus:border-primary h-10 placeholder:text-gray-500 px-4 pl-10 text-sm font-normal" 
                                            placeholder="Tìm kiếm phim..." 
                                            type="search" 
                                            required {{-- Thêm required nếu muốn bắt buộc nhập --}}
                                        />
                                    </label>
                                    {{-- Nút submit ẩn (để nhấn Enter là gửi form) --}}
                                    <button type="submit" class="hidden"></button>
                                </form>
                            </div>
                    
                    <div class="hidden lg:flex items-center">
                        @auth
                            {{-- Nếu đã đăng nhập --}}
                            <div class="relative ml-4">
                                <div>
                                    <button type="button" class="flex max-w-xs items-center rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-background-dark" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="sr-only">Open user menu</span>
                                        {{-- Thay thế bằng avatar thật nếu có --}}
                                        <span class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                             <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 256 256"><path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.79,40.31,185.67,25.08,212a8,8,0,0,0,13.84,8c18.1-31.33,50.62-52,89.08-52s71,20.67,89.08,52a8,8,0,0,0,13.84-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path></svg>
                                        </span>
                                        <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 hidden md:block">{{ Auth::user()->name }}</span>
                                        <svg class="ml-1 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </button>
                                </div>
                                
                                <div id="user-menu" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-800 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem" tabindex="-1">Hồ sơ cá nhân</a>
                                    <a href="{{ route('cart') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem" tabindex="-1">Giỏ hàng</a>
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
                    <button id="mobile-menu-button" class="lg:hidden text-gray-900 dark:text-white"><svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M224,128a8,8,0,0,1-8,8H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,128ZM40,88H216a8,8,0,0,0,0-16H40a8,8,0,0,0,0,16ZM216,184H40a8,8,0,0,0,0-16H216a8,8,0,0,0,0-16Z"></path></svg></button>
                </div>
            </div>
        </header>

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
                                    <a href="{{ route('profile') }}" class="w-full text-center rounded-lg h-12 flex items-center justify-center px-4 bg-gray-200 dark:bg-gray-700 text-sm font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">Hồ sơ cá nhân</a>
                                    <a href="{{ route('cart') }}" class="w-full text-center rounded-lg h-12 flex items-center justify-center px-4 bg-gray-200 dark:bg-gray-700 text-sm font-bold hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">Giỏ hàng</a>
                                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full rounded-lg h-12 px-4 bg-red-600/20 text-red-600 dark:text-red-500 text-sm font-bold hover:bg-red-600/30 transition-colors">Đăng xuất</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="w-full flex items-center justify-center overflow-hidden rounded-lg h-12 px-4 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-colors btn-glow"><span class="truncate">Đăng ký hoặc Đăng nhập</span></a>
                        @endauth
                    </div>
                    </div>
            </div>
        </div>



        <main class="py-4">
            @yield('content')
        </main>
        
        <footer class="bg-gray-100 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-800/50 mt-auto">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12"><div class="grid grid-cols-2 md:grid-cols-5 gap-8 text-center md:text-left"><a class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary" href="#">Introduction</a><a class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary" href="#">Terms</a><a class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary" href="#">Customer Care</a><a class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary" href="#">Connection</a><a class="text-sm text-gray-600 dark:text-gray-400 hover:text-primary" href="#">Download App</a></div><div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-800 flex flex-col sm:flex-row justify-between items-center"><p class="text-sm text-gray-500 dark:text-gray-400">© 2025 NeoScreem. All rights reserved.</p><div class="flex gap-4 mt-4 sm:mt-0"><a class="text-gray-400 hover:text-primary" href="#"><svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm8,191.63V152h24a8,8,0,0,0,0-16H136V112a16,16,0,0,1,16-16h16a8,8,0,0,0,0-16H152a32,32,0,0,0-32,32v24H96a8,8,0,0,0,0,16h24v63.63a88,88,0,1,1,16,0Z"></path></svg></a><a class="text-gray-400 hover:text-primary" href="#"><svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M247.39,68.94A8,8,0,0,0,240,64H209.57A48.66,48.66,0,0,0,168.1,40a46.91,46.91,0,0,0-33.75,13.7A47.9,47.9,0,0,0,120,88v6.09C79.74,83.47,46.81,50.72,46.46,50.37a8,8,0,0,0-13.65,4.92c-4.31,47.79,9.57,79.77,22,98.18a110.93,110.93,0,0,0,21.88,24.2c-15.23,17.53-39.21,26.74-39.47,26.84a8,8,0,0,0-3.85,11.93c.75,1.12,3.75,5.05,11.08,8.72C53.51,229.7,65.48,232,80,232c70.67,0,129.72-54.42,135.75-124.44l29.91-29.9A8,8,0,0,0,247.39,68.94Zm-45,29.41a8,8,0,0,0-2.32,5.14C196,166.58,143.28,216,80,216c-10.56,0-18-1.4-23.22-3.08,11.51-6.25,27.56-17,37.88-32.48A8,8,0,0,0,92,169.08c-.47-.27-43.91-26.34-44-96,16,13,45.25,33.17,78.67,38.79A8,8,0,0,0,136,104V88a32,32,0,0,1,9.6-22.92A30.94,30.94,0,0,1,167.9,56c12.66.16,24.49,7.88,29.44,19.21A8,8,0,0,0,204.67,80h16Z"></path></svg></a><a class="text-gray-400 hover:text-primary" href="#"><svg fill="currentColor" height="24" viewBox="0 0 256 256" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160ZM176,24H80A56.06,56.06,0,0,0,24,80v96a56.06,56.06,0,0,0,56,56h96a56.06,56.06,0,0,0,56-56V80A56.06,56.06,0,0,0,176,24Zm40,152a40,40,0,0,1-40,40H80a40,40,0,0,1-40-40V80A40,40,0,0,1,80,40h96a40,40,0,0,1,40,40ZM192,76a12,12,0,1,1-12-12A12,12,0,0,1,192,76Z"></path></svg></a></div></div>
            </div>
        </footer>
    </div>
    
    <div id="trailer-modal" class="fixed inset-0 z-[101] bg-black/80 backdrop-blur-sm items-center justify-center hidden">
        <div class="relative w-full max-w-3xl">
            <button id="close-modal-btn" class="absolute -top-10 -right-2 text-white text-4xl">&times;</button>
            <div class="aspect-video">
                <iframe id="trailer-iframe" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    
    <button id="back-to-top" class="fixed bottom-5 right-5 z-50 p-3 rounded-full bg-primary text-white shadow-lg hover:bg-primary/90 transition-opacity duration-300 opacity-0 btn-glow">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
    </button>
    <script src="https://cdn.jsdelivr.net/npm/atropos@2/atropos.min.js"></script>
    {{-- <script>
    document.addEventListener('DOMContentLoaded', () => {
        const slider = document.getElementById('phim-dang-chieu');
        const prevBtn = document.getElementById('pdc-prev-btn');
        const nextBtn = document.getElementById('pdc-next-btn');

        if (slider && prevBtn && nextBtn) {
            // Lấy chiều rộng 1 thẻ phim (tạm lấy thẻ đầu tiên)
            const cardWidth = slider.querySelector('.atropos')?.offsetWidth || 250;
            const scrollAmount = cardWidth * 2; // Cuộn 2 thẻ mỗi lần

            nextBtn.addEventListener('click', () => {
                slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });

            prevBtn.addEventListener('click', () => {
                slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const slider = document.getElementById('phim-sap-chieu');
        const prevBtn = document.getElementById('psc-prev-btn');
        const nextBtn = document.getElementById('psc-next-btn');

        if (slider && prevBtn && nextBtn) {
            // Lấy chiều rộng 1 thẻ phim (tạm lấy thẻ đầu tiên)
            const cardWidth = slider.querySelector('.atropos')?.offsetWidth || 250;
            const scrollAmount = cardWidth * 2; // Cuộn 2 thẻ mỗi lần

            nextBtn.addEventListener('click', () => {
                slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });

            prevBtn.addEventListener('click', () => {
                slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });
        }
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    // --- SLIDER ---
    const slides = [
            @foreach($phimDangChieu as $phim)
                {
                    title: `{!! addslashes($phim->ten_phim) !!}`,
                    description: `{!! addslashes(Str::limit($phim->tom_tat, 150)) !!}`,
                    image: `{{ asset('storage/' . $phim->anh_banner) }}`
                },
            @endforeach
        ];

    let currentSlide = 0;
    const banner = document.getElementById('banner-slider');
    const bannerTitle = document.getElementById('banner-title');
    const bannerDescription = document.getElementById('banner-description');
    const dotsContainer = document.getElementById('banner-dots');
    const prevBtn = document.getElementById('prev-slide');
    const nextBtn = document.getElementById('next-slide');
    let slideInterval;

    function showSlide(index) {
        if (!banner) return;

        const slide = slides[index];
        const overlay = document.createElement("div");
        overlay.className = "absolute inset-0 bg-cover bg-center opacity-0 transition-opacity duration-1000 ease-in-out";
        overlay.style.backgroundImage = `linear-gradient(90deg, rgba(18,18,18,0.8) 0%, rgba(18,18,18,0.6) 25%, rgba(18,18,18,0) 50%), url('${slide.image}')`;

        banner.appendChild(overlay);
        setTimeout(() => overlay.classList.add("opacity-100"), 10);

        bannerTitle.textContent = slide.title;
        bannerDescription.textContent = slide.description;

        const dots = dotsContainer.querySelectorAll('button');
        dots.forEach((dot, i) => {
            const isActive = i === index;
            dot.classList.toggle('bg-white', isActive);
            dot.classList.toggle('w-4', isActive);
            dot.classList.toggle('bg-white/50', !isActive);
            dot.classList.toggle('w-2', !isActive);
        });

        currentSlide = index;

        const oldOverlays = banner.querySelectorAll(".absolute.inset-0.bg-cover");
        if (oldOverlays.length > 1) {
            setTimeout(() => oldOverlays[0].remove(), 1000);
        }
    }

    function nextSlide() { showSlide((currentSlide + 1) % slides.length); }
    function prevSlide() { showSlide((currentSlide - 1 + slides.length) % slides.length); }

    function resetSlideInterval() {
        clearInterval(slideInterval);
        slideInterval = setInterval(nextSlide, 5000);
    }

    // Dots
    if (dotsContainer) {
        slides.forEach((_, i) => {
            const dot = document.createElement('button');
            dot.classList.add('h-2', 'rounded-full', 'transition-all', 'duration-300');
            dot.addEventListener('click', () => {
                showSlide(i);
                resetSlideInterval();
            });
            dotsContainer.appendChild(dot);
        });
    }

    if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetSlideInterval(); });
    if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetSlideInterval(); });

    showSlide(0);
    slideInterval = setInterval(nextSlide, 5000);

    // --- TRAILER MODAL ---
    const modal = document.getElementById('trailer-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const trailerIframe = document.getElementById('trailer-iframe');

    document.body.addEventListener('click', function (event) {
        const trailerButton = event.target.closest('.trailer-btn');
        if (trailerButton) {
            const trailerId = trailerButton.dataset.trailerId;
            if (trailerId && trailerIframe) {
                trailerIframe.src = `https://www.youtube.com/embed/${trailerId}?autoplay=1`;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }
    });

    function closeModal() {
        if (modal && trailerIframe) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            trailerIframe.src = '';
        }
    }
    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (modal) modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });

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
            tabContents.forEach(content => content.classList.toggle('hidden', content.id !== targetTabId));
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
            const scrollAmount = promoItem.offsetWidth + 32;
            scrollLeftBtn.addEventListener('click', () => promoContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' }));
            scrollRightBtn.addEventListener('click', () => promoContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' }));
        }
    }
});

</script> --}}
</body>
</html>