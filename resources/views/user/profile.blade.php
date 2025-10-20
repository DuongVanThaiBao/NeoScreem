<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin khách hàng - Tông Đỏ-Đen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
            /* Nền đen chính */
        }

        .text-primary {
            --tw-text-opacity: 1;
            color: rgb(234 42 51 / var(--tw-text-opacity, 1));
        }
    </style>
</head>

<body class="text-gray-200">

    <header class="bg-black/80 backdrop-blur-sm sticky top-0 z-50 border-b border-red-500/30">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a class="flex items-center gap-3 text-gray-900 dark:text-white" href="{{ route('home') }}">
                    <svg class="h-8 w-8 text-primary" fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" d="M24 18.4228L42 11.475V34.3663C42 34.7796 41.7457 35.1504 41.3601 35.2992L24 42V18.4228Z" fill="currentColor" fill-rule="evenodd"></path>
                        <path clip-rule="evenodd" d="M24 8.18819L33.4123 11.574L24 15.2071L14.5877 11.574L24 8.18819ZM9 15.8487L21 20.4805V37.6263L9 32.9945V15.8487ZM27 37.6263V20.4805L39 15.8487V32.9945L27 37.6263ZM25.354 2.29885C24.4788 1.98402 23.5212 1.98402 22.646 2.29885L4.98454 8.65208C3.7939 9.08038 3 10.2097 3 11.475V34.3663C3 36.0196 4.01719 37.5026 5.55962 38.098L22.9197 44.7987C23.6149 45.0671 24.3851 45.0671 25.0803 44.7987L42.4404 38.098C43.9828 37.5026 45 36.0196 45 34.3663V11.475C45 10.2097 44.2061 9.08038 43.0155 8.65208L25.354 2.29885Z" fill="currentColor" fill-rule="evenodd"></path>
                    </svg>
                    <h1 class="text-xl font-bold">NeoScreem</h1>
                </a>
                <nav class="hidden lg:flex items-center space-x-8 text-sm font-medium">
                    <a href="#" class="hover:text-red-500 transition">LỊCH CHIẾU</a>
                    <a href="#" class="hover:text-red-500 transition">KHUYẾN MÃI</a>
                    <a href="#" class="hover:text-red-500 transition">VỀ CHÚNG TÔI</a>
                </nav>
                <div class="relative ml-4">
                    <div>
                        <button type="button" class="flex max-w-xs items-center rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-background-dark" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            {{-- Thay thế bằng avatar thật nếu có --}}
                            <span class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 256 256">
                                    <path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.79,40.31,185.67,25.08,212a8,8,0,0,0,13.84,8c18.1-31.33,50.62-52,89.08-52s71,20.67,89.08,52a8,8,0,0,0,13.84-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path>
                                </svg>
                            </span>
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 hidden md:block">{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div id="user-menu" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-800 py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <a href="{{ route('cart') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem" tabindex="-1">Giỏ hàng</a>
                        <form action="{{ route('logout') }}" method="POST" role="none">
                            @csrf
                            <button type="submit" class="block w-full px-4 py-2 text-left text-sm text-red-600 dark:text-red-500 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem" tabindex="-1">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto p-4 md:p-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <aside class="lg:col-span-1 bg-gray-900/70 p-6 rounded-lg self-start">
                <div class="flex items-center space-x-4 mb-6">
                    <img class="h-16 w-16 rounded-full border-2 border-red-500" src="https://i.pravatar.cc/150?u=a042581f4e29026704d" alt="User avatar">
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
                    <a href="{{ route('profile') }}"
                        class="flex items-center p-3 rounded-lg transition-colors 
              {{ request()->routeIs('profile') ? 'bg-red-600 text-white font-bold' : 'hover:bg-gray-800' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <span>Thông tin khách hàng</span>
                    </a>

                    <a href="{{ route('profile.membership') }}"
                        class="flex items-center p-3 rounded-lg transition-colors 
              {{ request()->routeIs('profile.membership') ? 'bg-red-600 text-white font-bold' : 'hover:bg-gray-800' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v1H5V4zM5 8h10a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1V9a1 1 0 011-1z" />
                        </svg>
                        <span>Thành viên NeoScreem</span>
                    </a>

                    <a href="{{ route('profile.history') }}"
                        class="flex items-center p-3 rounded-lg transition-colors 
              {{ request()->routeIs('profile.history') ? 'bg-red-600 text-white font-bold' : 'hover:bg-gray-800' }}">

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
                        <button href="#" class="flex items-center p-3 rounded-lg hover:bg-red-900/50 transition-colors text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            <span>Đăng xuất</span>
                        </button>
                    </form>
                </div>
            </aside>

            <div class="lg:col-span-3">
                <h1 class="text-3xl font-bold text-white mb-6">THÔNG TIN KHÁCH HÀNG</h1>
                {{-- Dán vào dưới thẻ h1 --}}
                @if (session('status'))
                <div class="mb-4 p-4 text-sm text-green-300 bg-green-800/50 rounded-lg" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 p-4 text-sm text-red-300 bg-red-800/50 rounded-lg" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="bg-gray-900 p-8 rounded-lg shadow-xl mb-8">
                    <h2 class="text-2xl font-bold mb-6 text-white">Thông tin cá nhân</h2>
                    <form method="POST" action="{{ route('profile.update.info') }}" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf
                        <div>
                            <label for="fullName" class="block text-sm font-medium text-gray-400">Họ và tên</label>
                            <input type="text" id="fullName" name="fullName" value="{{ Auth::user()->name }}" class="mt-1 block w-full bg-gray-800 border-gray-600 text-white rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="dob" class="block text-sm font-medium text-gray-400">Ngày lập tài khoản</label>
                            <input type="date" id="dob" value="2006-01-25" class="mt-1 block w-full bg-gray-800 border-gray-600 text-white rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" readonly>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-400">Email</label>
                            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" class="mt-1 block w-full bg-gray-800 border-gray-600 text-white rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="w-auto bg-red-600 text-white font-bold py-2 px-6 rounded-md hover:bg-red-700 transition-colors">LƯU THÔNG TIN</button>
                        </div>
                    </form>
                </div>

                <div class="bg-gray-900 p-8 rounded-lg shadow-xl">
                    <h2 class="text-2xl font-bold mb-6 text-white">Đổi mật khẩu</h2>
                    <form method="POST" action="{{ route('profile.update.password') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="oldPassword" class="block text-sm font-medium text-gray-400">Mật khẩu cũ *</label>
                            <input type="password" id="oldPassword" name="oldPassword" class="mt-1 block w-full bg-gray-800 border-gray-600 text-white rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="newPassword" class="block text-sm font-medium text-gray-400">Mật khẩu mới *</label>
                            <input type="password" id="newPassword" name="newPassword" class="mt-1 block w-full bg-gray-800 border-gray-600 text-white rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="confirmPassword" class="block text-sm font-medium text-gray-400">Xác thực mật khẩu *</label>
                            <input type="password" id="confirmPassword" name="confirmPassword" class="mt-1 block w-full bg-gray-800 border-gray-600 text-white rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                        <div>
                            <button type="submit" class="w-auto bg-red-600 text-white font-bold py-2 px-6 rounded-md hover:bg-red-700 transition-colors">ĐỔI MẬT KHẨU</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
    <script>
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        if (userMenuButton) {
            userMenuButton.addEventListener('click', () => {
                const isExpanded = userMenuButton.getAttribute('aria-expanded') === 'true';
                userMenuButton.setAttribute('aria-expanded', !isExpanded);
                userMenu.classList.toggle('hidden');
            });

            // Close dropdown if clicked outside
            document.addEventListener('click', (event) => {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenuButton.setAttribute('aria-expanded', 'false');
                    userMenu.classList.add('hidden');
                }
            });
        }
    </script>
</body>

</html>