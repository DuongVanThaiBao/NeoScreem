<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chiến dịch Marketing - NeoScreem</title>
    <link href="/favicon.svg" rel="icon" type="image/svg+xml" onerror="this.href='/favicon.ico'"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-dark-bg { background-color: #1f2937; }
        .glass-morphism { background: rgba(26, 26, 26, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(79, 195, 247, 0.15); }
        .layout { display: flex; min-height: 100vh; }
        .main-content { flex: 1; position: relative; z-index: 20; min-height: 100vh; }
        .sidebar { width: 250px; background: inherit; height: 100vh; position: sticky; top: 0; z-index: 10; overflow-y: auto; }
        .card { background: rgba(26,26,26,0.8); backdrop-filter: blur(10px); border: 1px solid rgba(79,195,247,0.15); border-radius: .5rem; padding: 1.25rem; }
        textarea, select, input[type="text"] { background:#111827; border-color:#374151; color:#fff; }
    </style>
</head>
<body class="bg-dark-bg text-white font-sans">
<header class="glass-morphism border-b border-dark-border header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-retail-green rounded-lg flex items-center justify-center">
                    <i class="fas fa-bullhorn text-dark-bg text-lg"></i>
                </div>
                <span class="text-xl font-bold text-white">Chiến dịch Marketing</span>
            </div>
            <!-- Admin Info -->
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <div class="text-sm font-medium text-white">Administrator</div>
                    <div class="text-xs text-gray-400">Administrator</div>
                </div>
                <div class="relative">
                    <button class="flex items-center space-x-2 text-white hover:text-retail-green transition-colors">
                        <div class="w-8 h-8 bg-retail-green rounded-full flex items-center justify-center">
                            <span class="text-dark-bg font-bold text-sm">A</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="layout">
    <!-- Sidebar copied from dashboard -->
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
                        <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                            <i class="fas fa-users text-gray-400"></i>
                            <span>Quản lý người dùng</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
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
                        <a href="{{ route('admin.marketing.campaigns') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25">
                            <i class="fas fa-bullhorn text-retail-green"></i>
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
        <div class="card">
            <h3 class="text-lg font-semibold text-white mb-4">Gợi ý nội dung chiến dịch</h3>
            <form class="space-y-4" method="GET" action="#">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-gray-400 text-sm">Thể loại phim</label>
                        <select name="genre" class="w-full mt-1 px-3 py-2 border rounded">
                            <option value="action">Hành động</option>
                            <option value="romance">Tình cảm</option>
                            <option value="horror">Kinh dị</option>
                            <option value="animation">Hoạt hình</option>
                            <option value="comedy">Hài</option>
                            <option value="drama">Tâm lý</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Mục tiêu chiến dịch</label>
                        <select name="goal" class="w-full mt-1 px-3 py-2 border rounded">
                            <option value="launch">Ra mắt phim</option>
                            <option value="theater">Thu hút người xem rạp</option>
                            <option value="streaming">Quảng bá nền tảng streaming</option>
                            <option value="retarget">Tái tiếp cận khách hàng cũ</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-gray-400 text-sm">Kênh truyền thông chính</label>
                        <select name="channel" class="w-full mt-1 px-3 py-2 border rounded">
                            <option value="facebook">Facebook</option>
                            <option value="tiktok">TikTok</option>
                            <option value="youtube">YouTube</option>
                            <option value="press">Báo chí</option>
                            <option value="email">Email</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="text-gray-400 text-sm">Ghi chú thêm (tuỳ chọn)</label>
                    <textarea name="notes" rows="3" class="w-full mt-1 px-3 py-2 border rounded" placeholder="Đặc điểm khán giả, ngân sách, thời gian chạy..."></textarea>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg transition-colors">
                        <i class="fas fa-magic mr-2"></i>Gợi ý chiến dịch
                    </button>
                </div>
            </form>
        </div>

        <div class="card">
            <h3 class="text-lg font-semibold text-white mb-4">Kịch bản đề xuất</h3>
            <div class="text-gray-300 text-sm">
                <p>Điền form trên để nhận gợi ý content phù hợp: thông điệp chính, lịch đăng bài, định dạng nội dung (video 15s TikTok, trailer cắt ngắn YouTube, bài PR báo chí), CTA và KPIs theo mục tiêu.</p>
            </div>
        </div>
    </main>
</div>
</body>
</html>
