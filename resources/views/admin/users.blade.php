<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý Người dùng - NeoScreem</title>
    <link href="/favicon.svg" rel="icon" type="image/svg+xml" onerror="this.href='/favicon.ico'"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-dark-bg { background-color: #1f2937; }
        .glass-morphism { background: rgba(26,26,26,0.8); backdrop-filter: blur(10px); border: 1px solid rgba(79,195,247,0.15); }
        .layout { display: flex; min-height: 100vh; }
        .main-content { flex: 1; position: relative; z-index: 20; min-height: 100vh; }
        .sidebar { width: 250px; background: inherit; height: 100vh; position: sticky; top: 0; z-index: 10; overflow-y: auto; }
        .chart-container { background: rgba(26,26,26,0.8); backdrop-filter: blur(10px); border: 1px solid rgba(79,195,247,0.15); border-radius: .5rem; padding: 1.5rem; }
        .table thead th { font-weight: 600; color: #9ca3af; font-size: .75rem; }
    </style>
</head>
<body class="bg-dark-bg text-white font-sans">
    <!-- Header -->
    <header class="glass-morphism border-b border-dark-border header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-retail-green rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-dark-bg text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Quản lý Người dùng</span>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-lg mx-8">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <form method="GET" action="{{ route('admin.users.index') }}" class="block" id="userSearchForm">
                            <input type="text"
                                   name="q"
                                   id="q"
                                   class="block w-full pl-10 pr-3 py-2 border border-dark-border rounded-lg bg-dark-surface text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent"
                                   placeholder="Tìm kiếm tên hoặc email..."
                                   value="{{ request('q') }}">
                        </form>
                    </div>
                </div>

                <!-- Admin Info -->
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-400">Administrator</div>
                    </div>
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-white hover:text-retail-green transition-colors">
                            <div class="w-8 h-8 bg-retail-green rounded-full flex items-center justify-center">
                                <span class="text-dark-bg font-bold text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar bg-dark-surface border-r border-dark-border flex flex-col">
            <!-- Logo in Sidebar -->
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

            <!-- Navigation Menu -->
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
                            <a href="/admin/stores" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-store text-gray-400"></i>
                                <span>Quản lý cửa hàng</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/movies" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-film text-gray-400"></i>
                                <span>Quản lý phim</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25">
                                <i class="fas fa-users text-retail-green"></i>
                                <span>Quản lý người dùng</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/orders" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
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
                            <a href="/admin/hr/employees" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-users text-gray-400"></i>
                                <span>Quản lý nhân sự</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/hr/schedules" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-calendar-check text-gray-400"></i>
                                <span>Lịch làm việc</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/hr/reports" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
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
                            <a href="/admin/system/settings" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-cog text-gray-400"></i>
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
                            <a href="/admin/system/backup" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-database text-gray-400"></i>
                                <span>Sao lưu dữ liệu</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/logs" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-file-alt text-gray-400"></i>
                                <span>Nhật ký hệ thống</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Logout Button -->
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

        <!-- Main Content -->
        <main class="main-content p-6 space-y-6">
            <!-- Filters & Actions -->
            <div class="chart-container">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                    <h3 class="text-lg font-semibold text-white">Danh sách người dùng</h3>
                    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-center gap-2">
                        <select name="role" class="px-3 py-1 bg-dark-surface border border-dark-border rounded text-white text-sm">
                            <option value="">Tất cả vai trò</option>
                            <option value="admin" @selected(request('role')==='admin')>Admin</option>
                            <option value="staff" @selected(request('role')==='staff')>Nhân viên</option>
                            <option value="customer" @selected(request('role')==='customer')>Khách hàng</option>
                        </select>
                        <select name="status" class="px-3 py-1 bg-dark-surface border border-dark-border rounded text-white text-sm">
                            <option value="">Tất cả trạng thái</option>
                            <option value="active" @selected(request('status')==='active')>Hoạt động</option>
                            <option value="banned" @selected(request('status')==='banned')>Bị khóa</option>
                        </select>
                        <button class="px-3 py-1 bg-retail-green/20 border border-retail-green/40 rounded text-white text-sm">Lọc</button>
                    </form>
                </div>

                <!-- Users table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left border-b border-dark-border">
                                <th class="px-3 py-2 text-gray-400 text-xs">Tên</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Email</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Vai trò</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Trạng thái</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Ngày đăng ký</th>
                                <th class="px-3 py-2 text-gray-400 text-xs text-right">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $u)
                                <tr class="border-b border-dark-border/60 hover:bg-white/5">
                                    <td class="px-3 py-2">{{ $u->name }}</td>
                                    <td class="px-3 py-2">{{ $u->email }}</td>
                                    <td class="px-3 py-2">{{ $u->role ?? '—' }}</td>
                                    <td class="px-3 py-2">
                                        @if(isset($u->banned_at))
                                            <span class="text-xs px-2 py-1 rounded {{ $u->banned_at ? 'bg-red-500/20 text-red-300' : 'bg-green-500/20 text-green-300' }}">{{ $u->banned_at ? 'Bị khóa' : 'Hoạt động' }}</span>
                                        @else
                                            <span class="text-xs px-2 py-1 rounded bg-green-500/20 text-green-300">Hoạt động</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">{{ optional($u->created_at)->format('d/m/Y') }}</td>
                                    <td class="px-3 py-2">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $u->id) }}" title="Sửa" class="px-2 py-1 text-blue-400 hover:text-blue-300">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Xác nhận xóa/vô hiệu hóa người dùng này?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" title="Xóa" class="px-2 py-1 text-red-400 hover:text-red-300">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-3 py-6 text-center text-gray-400">Không có người dùng phù hợp</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">{{ $users->links() }}</div>
            </div>
        </main>
    </div>
</body>
</html>
