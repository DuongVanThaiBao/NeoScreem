<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cài đặt hệ thống - NeoScreem</title>
    <link href="/favicon.svg" rel="icon" type="image/svg+xml" onerror="this.href='/favicon.ico'"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" onerror="console.warn('Font Awesome failed to load')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-dark-bg{background-color:#1f2937}
        .glass-morphism{background:rgba(26,26,26,.8);backdrop-filter:blur(10px);border:1px solid rgba(79,195,247,.15)}
        .layout{display:flex;min-height:100vh}
        .sidebar{width:250px;background:inherit;height:100vh;position:sticky;top:0;z-index:10;overflow-y:auto}
        .sidebar-item{transition:all .3s ease}
        .sidebar-item:hover{background:rgba(79,195,247,.08);transform:translateX(3px)}
        .sidebar-item.active{background:rgba(79,195,247,.1);border-left:3px solid #4fd3f7}
        .bg-dark-surface{background:#111827}
        .border-dark-border{border-color:#374151}
        .text-retail{color:#4fd3f7}
    </style>
</head>
<body class="bg-dark-bg text-white font-sans">
    <header class="glass-morphism border-b border-dark-border header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-retail-green rounded-lg flex items-center justify-center">
                        <i class="fas fa-cog text-dark-bg text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Cài đặt hệ thống</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-400">Administrator</div>
                    </div>
                    <div class="w-8 h-8 bg-retail-green rounded-full flex items-center justify-center">
                        <span class="text-dark-bg font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="layout">
        <aside class="sidebar bg-dark-surface border-r border-dark-border flex flex-col">
            <div class="p-6 border-b border-dark-border">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-retail-green rounded-lg flex items-center justify-center">
                        <i class="fas fa-film text-dark-bg text-xl"></i>
                    </div>
                    <div>
                        <div class="text-white font-bold">NeoScreem</div>
                        <div class="text-xs text-gray-400">Cinema Management</div>
                    </div>
                </div>
            </div>
            <nav class="flex-1 p-4">
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Chính</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('admin.admin') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-home text-gray-400"></i>
                                <span>Trang chủ</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dashboard.stats') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-tachometer-alt text-gray-400"></i>
                                <span>RetailPulse Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Quản lý</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="/admin/stores" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-store text-gray-400"></i>
                                <span>Quản lý cửa hàng</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/movies" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-film text-gray-400"></i>
                                <span>Quản lý phim</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/users" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-users text-gray-400"></i>
                                <span>Quản lý người dùng</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/orders" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-ticket-alt text-gray-400"></i>
                                <span>Đơn hàng / Suất chiếu</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Marketing</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="/admin/marketing/campaigns" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-bullhorn text-gray-400"></i>
                                <span>Chiến dịch marketing</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/marketing/analytics" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-chart-pie text-gray-400"></i>
                                <span>Phân tích hiệu quả</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/marketing/targets" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-bullseye text-gray-400"></i>
                                <span>Target khách hàng</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Nhân sự</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('admin.hr.employees.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-users text-gray-400"></i>
                                <span>Quản lý nhân sự</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.hr.schedules') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-calendar-check text-gray-400"></i>
                                <span>Lịch làm việc</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/hr/reports') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-chart-bar text-gray-400"></i>
                                <span>Báo cáo nhân sự</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Hệ thống</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="/admin/system/settings" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25">
                                <i class="fas fa-cog text-retail"></i>
                                <span>Cài đặt hệ thống</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/security" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-shield-alt text-gray-400"></i>
                                <span>Bảo mật</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/backup" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-database text-gray-400"></i>
                                <span>Sao lưu dữ liệu</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/logs" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-file-alt text-gray-400"></i>
                                <span>Nhật ký hệ thống</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="p-4 border-t border-dark-border bg-dark-surface">
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 w-full text-left transition-colors">
                        <i class="fas fa-sign-out-alt text-gray-400"></i>
                        <span>Đăng xuất</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 relative overflow-hidden">
            <div class="p-8" style="position: relative; z-index: 10;">
                @if (session('success'))
                <div id="success-message" class="fixed top-4 right-4 glass-morphism text-green-400 p-4 rounded-lg border border-green-500/30" style="z-index: 9999;">
                    {{ session('success') }}
                </div>
                @endif

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Cài đặt hệ thống</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 text-gray-800">
        <form method="POST" action="{{ route('admin.system.settings.update') }}">
            @csrf
            @method('PUT')
            
            <!-- Thông tin chung -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b">
                    <i class="fas fa-info-circle mr-2"></i>Thông tin chung
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tên rạp</label>
                        <input type="text" name="cinema_name" value="{{ old('cinema_name', $settings['cinema_name'] ?? 'NeoScreem Cinema') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                        <input type="text" name="phone" value="{{ old('phone', $settings['phone'] ?? '') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                        <input type="text" name="address" value="{{ old('address', $settings['address'] ?? '') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <!-- Cài đặt giờ làm việc -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b">
                    <i class="far fa-clock mr-2"></i>Giờ làm việc
                </h2>
                
                <div class="space-y-4">
                    @php
                        $workHours = $settings['work_hours'] ?? [
                            'monday' => ['open' => '08:00', 'close' => '23:00'],
                            'tuesday' => ['open' => '08:00', 'close' => '23:00'],
                            'wednesday' => ['open' => '08:00', 'close' => '23:00'],
                            'thursday' => ['open' => '08:00', 'close' => '23:00'],
                            'friday' => ['open' => '08:00', 'close' => '23:30'],
                            'saturday' => ['open' => '09:00', 'close' => '23:30'],
                            'sunday' => ['open' => '09:00', 'close' => '22:30']
                        ];
                        
                        $days = [
                            'monday' => 'Thứ Hai',
                            'tuesday' => 'Thứ Ba',
                            'wednesday' => 'Thứ Tư',
                            'thursday' => 'Thứ Năm',
                            'friday' => 'Thứ Sáu',
                            'saturday' => 'Thứ Bảy',
                            'sunday' => 'Chủ Nhật'
                        ];
                    @endphp
                    
                    @foreach($days as $key => $day)
                    <div class="grid grid-cols-12 items-center">
                        <div class="col-span-2 font-medium">{{ $day }}</div>
                        <div class="col-span-4 flex items-center space-x-2">
                            <input type="time" name="work_hours[{{ $key }}][open]" 
                                   value="{{ old('work_hours.'.$key.'.open', $workHours[$key]['open'] ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                            <span>đến</span>
                            <input type="time" name="work_hours[{{ $key }}][close]" 
                                   value="{{ old('work_hours.'.$key.'.close', $workHours[$key]['close'] ?? '') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="col-span-6 ml-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="work_hours[{{ $key }}][is_holiday]" 
                                       {{ (old('work_hours.'.$key.'.is_holiday', $workHours[$key]['is_holiday'] ?? false) ? 'checked' : '') }} 
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-600">Ngày nghỉ</span>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Cài đặt giá vé -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b">
                    <i class="fas fa-ticket-alt mr-2"></i>Giá vé mặc định
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vé thường (2D)</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₫</span>
                            </div>
                            <input type="number" name="ticket_prices[standard]" 
                                   value="{{ old('ticket_prices.standard', $settings['ticket_prices']['standard'] ?? 60000) }}" 
                                   class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vé 3D</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₫</span>
                            </div>
                            <input type="number" name="ticket_prices[3d]" 
                                   value="{{ old('ticket_prices.3d', $settings['ticket_prices']['3d'] ?? 80000) }}" 
                                   class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vé IMAX</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₫</span>
                            </div>
                            <input type="number" name="ticket_prices[imax]" 
                                   value="{{ old('ticket_prices.imax', $settings['ticket_prices']['imax'] ?? 100000) }}" 
                                   class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cài đặt khác -->
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b">
                    <i class="fas fa-cog mr-2"></i>Cài đặt khác
                </h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="maintenance_mode" name="maintenance_mode" type="checkbox" 
                                   {{ old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="maintenance_mode" class="font-medium text-gray-700">Chế độ bảo trì</label>
                            <p class="text-gray-500">Kích hoạt để tạm dừng đặt vé</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="allow_online_booking" name="allow_online_booking" type="checkbox" 
                                   {{ old('allow_online_booking', $settings['allow_online_booking'] ?? true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="allow_online_booking" class="font-medium text-gray-700">Cho phép đặt vé online</label>
                            <p class="text-gray-500">Tắt để vô hiệu hóa đặt vé trực tuyến</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="enable_email_notifications" name="enable_email_notifications" type="checkbox" 
                                   {{ old('enable_email_notifications', $settings['enable_email_notifications'] ?? true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="enable_email_notifications" class="font-medium text-gray-700">Gửi thông báo email</label>
                            <p class="text-gray-500">Gửi email xác nhận đặt vé và thông báo</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lưu cài đặt -->
            <div class="flex justify-end pt-4 border-t">
                <button type="button" onclick="window.history.back()" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Hủy bỏ
                </button>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

            </div>
        </main>
    </div>

    <script>
        // Auto hide success toast
        setTimeout(function(){ var m=document.getElementById('success-message'); if(m){ m.style.opacity='0'; setTimeout(function(){ m.remove(); }, 300); } }, 3000);
    </script>
</body>
</html>
