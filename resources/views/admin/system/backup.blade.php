<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sao lưu dữ liệu - NeoScreem</title>
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
                        <i class="fas fa-database text-dark-bg text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Sao lưu dữ liệu</span>
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
                        <li><a href="{{ route('admin.admin') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-home text-gray-400"></i><span>Trang chủ</span></a></li>
                        <li><a href="{{ route('admin.dashboard.stats') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-tachometer-alt text-gray-400"></i><span>RetailPulse Dashboard</span></a></li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Quản lý</h3>
                    <ul class="space-y-2">
                        <li><a href="/admin/stores" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-store text-gray-400"></i><span>Quản lý cửa hàng</span></a></li>
                        <li><a href="/admin/movies" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-film text-gray-400"></i><span>Quản lý phim</span></a></li>
                        <li><a href="/admin/users" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-users text-gray-400"></i><span>Quản lý người dùng</span></a></li>
                        <li><a href="/admin/orders" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-ticket-alt text-gray-400"></i><span>Đơn hàng / Suất chiếu</span></a></li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Marketing</h3>
                    <ul class="space-y-2">
                        <li><a href="/admin/marketing/campaigns" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-bullhorn text-gray-400"></i><span>Chiến dịch marketing</span></a></li>
                        <li><a href="/admin/marketing/analytics" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-chart-pie text-gray-400"></i><span>Phân tích hiệu quả</span></a></li>
                        <li><a href="/admin/marketing/targets" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-bullseye text-gray-400"></i><span>Target khách hàng</span></a></li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Nhân sự</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('admin.hr.employees.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-users text-gray-400"></i><span>Quản lý nhân sự</span></a></li>
                        <li><a href="{{ route('admin.hr.schedules') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-calendar-check text-gray-400"></i><span>Lịch làm việc</span></a></li>
                        <li><a href="{{ url('/admin/hr/reports') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-chart-bar text-gray-400"></i><span>Báo cáo nhân sự</span></a></li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Hệ thống</h3>
                    <ul class="space-y-2">
                        <li><a href="/admin/system/settings" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-cog text-gray-400"></i><span>Cài đặt hệ thống</span></a></li>
                        <li><a href="/admin/system/security" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-shield-alt text-gray-400"></i><span>Bảo mật</span></a></li>
                        <li><a href="/admin/system/backup" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25"><i class="fas fa-database text-retail"></i><span>Sao lưu dữ liệu</span></a></li>
                        <li><a href="/admin/system/logs" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-file-alt text-gray-400"></i><span>Nhật ký hệ thống</span></a></li>
                    </ul>
                </div>
            </nav>
            <div class="p-4 border-t border-dark-border bg-dark-surface">
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">@csrf<button type="submit" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 w-full text-left transition-colors"><i class="fas fa-sign-out-alt text-gray-400"></i><span>Đăng xuất</span></button></form>
            </div>
        </aside>

        <main class="flex-1 relative overflow-hidden">
            <div class="p-8" style="position: relative; z-index: 10;">
                @if (session('success'))
                <div id="success-message" class="fixed top-4 right-4 glass-morphism text-green-400 p-4 rounded-lg border border-green-500/30" style="z-index: 9999;">{{ session('success') }}</div>
                @endif

                <div class="container mx-auto px-4 py-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-100">Sao lưu dữ liệu</h1>
                        <form method="POST" action="{{ route('admin.system.backup.create') }}">@csrf
                            <button type="submit" class="px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg"><i class="fas fa-plus mr-2"></i>Tạo bản sao lưu</button>
                        </form>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-0 text-gray-800 overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tệp</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kích thước</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cập nhật</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($backups as $b)
                                <tr>
                                    <td class="px-6 py-3 font-mono text-sm">{{ $b['name'] }}</td>
                                    <td class="px-6 py-3 text-sm">{{ $b['size'] }}</td>
                                    <td class="px-6 py-3 text-sm">{{ $b['modified'] }}</td>
                                    <td class="px-6 py-3 text-right space-x-2">
                                        <a class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded" href="{{ route('admin.system.backup.download', ['file'=>$b['name']]) }}"><i class="fas fa-download mr-2"></i>Tải</a>
                                        <form method="POST" action="{{ route('admin.system.backup.delete', ['file'=>$b['name']]) }}" style="display:inline">@csrf<button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded"><i class="fas fa-trash mr-2"></i>Xóa</button></form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-6 text-center text-gray-500">Chưa có bản sao lưu nào</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>setTimeout(function(){ var m=document.getElementById('success-message'); if(m){ m.style.opacity='0'; setTimeout(function(){ m.remove(); }, 300); } }, 3000);</script>
</body>
</html>
