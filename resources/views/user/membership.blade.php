<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thành viên NeoScreem - Tông Đỏ-Đen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
        }

        .text-primary {
            --tw-text-opacity: 1;
            color: rgb(234 42 51 / var(--tw-text-opacity, 1));
        }
    </style>
</head>

<body class="text-gray-200">

    {{-- HEADER GIỮ NGUYÊN --}}
    <header class="bg-black/80 backdrop-blur-sm sticky top-0 z-50 border-b border-red-500/30">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a class="flex items-center gap-3" href="{{ route('home') }}">
                    <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" d="M24 18.4228L42 11.475V34.3663C42 34.7796 41.7457 35.1504 41.3601 35.2992L24 42V18.4228Z" fill="currentColor" fill-rule="evenodd"></path>
                        <path clip-rule="evenodd" d="M24 8.18819L33.4123 11.574L24 15.2071L14.5877 11.574L24 8.18819ZM9 15.8487L21 20.4805V37.6263L9 32.9945V15.8487ZM27 37.6263V20.4805L39 15.8487V32.9945L27 37.6263ZM25.354 2.29885C24.4788 1.98402 23.5212 1.98402 22.646 2.29885L4.98454 8.65208C3.7939 9.08038 3 10.2097 3 11.475V34.3663C3 36.0196 4.01719 37.5026 5.55962 38.098L22.9197 44.7987C23.6149 45.0671 24.3851 45.0671 25.0803 44.7987L42.4404 38.098C43.9828 37.5026 45 36.0196 45 34.3663V11.475C45 10.2097 44.2061 9.08038 43.0155 8.65208L25.354 2.29885Z" fill="currentColor" fill-rule="evenodd"></path>
                    </svg>
                    <h1 class="text-xl font-bold text-white">NeoScreem</h1>
                </a>
                <nav class="hidden lg:flex items-center space-x-8 text-sm font-medium">
                    <a href="#" class="hover:text-red-500 transition">LỊCH CHIẾU</a>
                    <a href="#" class="hover:text-red-500 transition">KHUYẾN MÃI</a>
                    <a href="#" class="hover:text-red-500 transition">VỀ CHÚNG TÔI</a>
                </nav>
                <div class="relative ml-4">
                    {{-- Dropdown menu user giữ nguyên --}}
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto p-4 md:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- SIDEBAR GIỮ NGUYÊN --}}
            <aside class="lg:col-span-1 bg-gray-900/70 p-6 rounded-lg self-start">
                {{-- Dán code sidebar của bạn vào đây --}}
                <div class="flex items-center space-x-4 mb-6">
                    <img class="h-16 w-16 rounded-full border-2 border-red-500" src="https://i.pravatar.cc/150?u={{ Auth::user()->id }}" alt="User avatar">
                    <div>
                        <h2 class="font-bold text-lg text-white">{{ Auth::user()->name }}</h2>
                        <a href="#" class="text-xs text-gray-400 hover:text-red-500">Thay đổi ảnh đại diện</a>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-red-600 to-red-800 text-white p-4 rounded-lg mb-6 shadow-lg">
                    <h3 class="font-bold text-xl">C'Friends</h3>
                    <p class="text-sm">Thành viên</p>
                </div>

                <div class="bg-gray-800/80 p-4 rounded-lg mb-6">
                    <p class="text-sm text-gray-400">Tích điểm NeoScreem</p>
                    <div class="w-full bg-gray-700 rounded-full h-2.5 my-2">
                        <div class="bg-red-600 h-2.5 rounded-full" style="width: 10%"></div>
                    </div>
                    <p class="font-bold text-lg text-red-500">0/10K</p>
                </div>

                <nav class="space-y-2">
                    <a href="{{ route('profile') }}" class="flex items-center p-3 rounded-lg transition-colors {{ request()->routeIs('profile') ? 'bg-red-600 text-white font-bold' : 'hover:bg-red-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <span>Thông tin khách hàng</span>
                    </a>
                    <a href="{{ route('profile.membership') }}" class="flex items-center p-3 rounded-lg transition-colors {{ request()->routeIs('profile.membership') ? 'bg-red-600 text-white font-bold' : 'hover:bg-red-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v1H5V4zM5 8h10a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1V9a1 1 0 011-1z" />
                        </svg>
                        <span>Thành viên NeoScreem</span>
                    </a>
                    <a href="{{ route('profile.history') }}" class="flex items-center p-3 rounded-lg transition-colors {{ request()->routeIs('profile.history') ? 'bg-red-600 text-white font-bold' : 'hover:bg-red-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h4a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                        <span>Lịch sử mua hàng</span>
                    </a>
                </nav>

                <div class="mt-8 border-t border-gray-700 pt-4">
                    <form action="{{ route('logout') }}" method="POST" role="none">
                        @csrf
                        <button type="submit" class="w-full flex items-center p-3 rounded-lg hover:bg-red-900/50 transition-colors text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            <span>Đăng xuất</span>
                        </button>
                    </form>
                </div>
            </aside>

            <div class="lg:col-span-3">
                <h1 class="text-3xl font-bold text-white mb-6">THÀNH VIÊN NEOSCREEM</h1>

                <div class="bg-gray-900 p-8 rounded-lg shadow-xl mb-8 flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-shrink-0">
                        <div class="w-32 h-32 bg-white p-2 rounded-lg flex items-center justify-center">
                            <svg class="w-full h-full text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M140,116h16v16H140Zm40,40h16v16H180ZM140,156h16v16H140ZM116,40H40v76h76Zm-16,60H56V56h44ZM40,140H56v16H40Zm16,16h16v16H56Zm16,16H56v16H72Zm16,0v16h16V172Zm0-16H72V140H88Zm44,44H116v16h16Zm16-16H116v16h16Zm16,16h-16v16h16Zm16-16v16h16V188Zm16-16h-16v16h16Zm16,0v16h16V172Zm0-16h-16v16h16Zm-44-16h16v16H156Zm-40-28a12,12,0,1,0-12-12A12,12,0,0,0,116,116Zm124,116a12,12,0,1,1-12-12A12,12,0,0,1,240,232Zm-12-68a12,12,0,1,0-12-12A12,12,0,0,0,228,164ZM200,40a12,12,0,1,0,12,12A12,12,0,0,0,200,40ZM116,164a12,12,0,1,0-12-12A12,12,0,0,0,116,164ZM40,212a12,12,0,1,0,12,12A12,12,0,0,0,40,212Z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="flex justify-between items-baseline">
                            <h2 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h2>
                            <p class="text-sm font-medium text-red-500">ID: NS{{ str_pad(Auth::user()->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="bg-gradient-to-r from-red-600 to-red-800 text-white p-3 rounded-md my-4 shadow-lg">
                            <h3 class="font-bold text-lg">C'Friends</h3>
                            <p class="text-xs">Hạng thành viên hiện tại</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400 mb-1">Điểm tích lũy: <span class="font-bold text-white">0</span> / 10,000 để lên hạng</p>
                            <div class="w-full bg-gray-700 rounded-full h-2.5">
                                <div class="bg-red-600 h-2.5 rounded-full" style="width: 10%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 p-8 rounded-lg shadow-xl mb-8">
                    <h2 class="text-2xl font-bold text-white mb-6">Quyền lợi thành viên</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-gray-800/80 p-6 rounded-lg text-center">
                            <div class="w-12 h-12 bg-red-600/20 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2h3a2 2 0 002-2V7a2 2 0 00-2-2H5zM5 11h3a2 2 0 002-2V7a2 2 0 00-2-2H5m12 12a2 2 0 002-2v-3a2 2 0 00-2-2h-3a2 2 0 00-2 2v3a2 2 0 002 2h3a2 2 0 002-2v-3a2 2 0 00-2-2h-3m-3-4h3a2 2 0 002-2V7a2 2 0 00-2-2h-3a2 2 0 00-2 2v3a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-white">Giảm giá vé</h3>
                            <p class="text-sm text-gray-400 mt-1">Giảm đến 10% cho mỗi vé xem phim.</p>
                        </div>
                        <div class="bg-gray-800/80 p-6 rounded-lg text-center">
                            <div class="w-12 h-12 bg-red-600/20 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-white">Ưu đãi bắp nước</h3>
                            <p class="text-sm text-gray-400 mt-1">Combo bắp nước với giá cực kỳ ưu đãi.</p>
                        </div>
                        <div class="bg-gray-800/80 p-6 rounded-lg text-center">
                            <div class="w-12 h-12 bg-red-600/20 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-white">Quà tặng sinh nhật</h3>
                            <p class="text-sm text-gray-400 mt-1">Nhận một phần quà đặc biệt trong tháng sinh nhật.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 p-8 rounded-lg shadow-xl">
                    <h2 class="text-2xl font-bold text-white mb-6">Các Hạng Thẻ & Nâng Hạng</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="border-2 border-red-600 p-6 rounded-lg bg-gray-800/50 relative">
                            <div class="absolute top-0 right-4 -mt-3 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full">Hạng hiện tại</div>
                            <h3 class="text-2xl font-bold text-red-500">C'Friends</h3>
                            <p class="text-sm text-gray-400 mb-4">0 - 9,999 điểm</p>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>Tích điểm mỗi giao dịch</li>
                                <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>Ưu đãi từ đối tác</li>
                            </ul>
                        </div>
                        <div class="border border-gray-700 p-6 rounded-lg">
                            <h3 class="text-2xl font-bold text-yellow-500">C'Pro</h3>
                            <p class="text-sm text-gray-400 mb-4">10,000 - 29,999 điểm</p>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>Tất cả quyền lợi C'Friends</li>
                                <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>Giảm 5% giá vé</li>
                                <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>Quà sinh nhật giá trị</li>
                            </ul>
                        </div>
                        <div class="border border-gray-700 p-6 rounded-lg">
                            <h3 class="text-2xl font-bold text-cyan-400">C'VIP</h3>
                            <p class="text-sm text-gray-400 mb-4">Trên 30,000 điểm</p>
                            <ul class="space-y-2 text-sm">
                                <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>Tất cả quyền lợi C'Pro</li>
                                <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>Giảm 10% giá vé & bắp nước</li>
                                <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>Vé mời sự kiện đặc biệt</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script>
        // Script cho dropdown menu
    </script>
</body>

</html>