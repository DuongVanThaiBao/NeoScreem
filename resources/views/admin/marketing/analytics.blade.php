<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Phân tích hiệu quả - NeoScreem</title>
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
        .kpi { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); }
        .table thead th { font-weight: 600; color: #9ca3af; font-size: .75rem; }
    </style>
</head>
<body class="bg-dark-bg text-white font-sans">
<header class="glass-morphism border-b border-dark-border header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-retail-green rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-dark-bg text-lg"></i>
                </div>
                <span class="text-xl font-bold text-white">Phân tích hiệu quả</span>
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
    <!-- Sidebar (copy style from dashboard) -->
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
                    <li><a href="/admin/stores" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-store text-gray-400"></i><span>Quản lý cửa hàng</span></a></li>
                    <li><a href="/admin/movies" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-film text-gray-400"></i><span>Quản lý phim</span></a></li>
                    <li><a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-users text-gray-400"></i><span>Quản lý người dùng</span></a></li>
                    <li><a href="{{ route('admin.orders.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-ticket-alt text-gray-400"></i><span>Đơn hàng / Suất chiếu</span></a></li>
                </ul>
            </div>

            <div class="mb-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Marketing</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.marketing.campaigns') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-bullhorn text-gray-400"></i><span>Chiến dịch marketing</span></a></li>
                    <li><a href="{{ route('admin.marketing.analytics') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25"><i class="fas fa-chart-line text-retail-green"></i><span>Phân tích hiệu quả</span></a></li>
                    <li><a href="/admin/marketing/targets" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-bullseye text-gray-400"></i><span>Target khách hàng</span></a></li>
                </ul>
            </div>

            <div class="mb-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Hệ thống</h3>
                <ul class="space-y-2">
                    <li><a href="/admin/system/settings" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-cog text-gray-400"></i><span>Cài đặt hệ thống</span></a></li>
                    <li><a href="/admin/system/security" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-shield-alt text-gray-400"></i><span>Bảo mật</span></a></li>
                    <li><a href="/admin/system/backup" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-database text-gray-400"></i><span>Sao lưu dữ liệu</span></a></li>
                    <li><a href="/admin/system/logs" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-file-alt text-gray-400"></i><span>Nhật ký hệ thống</span></a></li>
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

    <!-- Main Content -->
    <main class="main-content p-6 space-y-6">
        <!-- Filters -->
        <div class="card">
            <form method="GET" action="{{ route('admin.marketing.analytics') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="text-gray-400 text-sm">Khoảng thời gian</label>
                    <select name="range" class="w-full mt-1 px-3 py-2 border rounded bg-dark-surface text-white border-dark-border">
                        <option value="today" {{ $range==='today' ? 'selected' : '' }}>Hôm nay</option>
                        <option value="last_7" {{ $range==='last_7' ? 'selected' : '' }}>7 ngày qua</option>
                        <option value="last_30" {{ $range==='last_30' ? 'selected' : '' }}>30 ngày qua</option>
                        <option value="custom" {{ $range==='custom' ? 'selected' : '' }}>Tùy chọn</option>
                    </select>
                </div>
                <div>
                    <label class="text-gray-400 text-sm">Từ ngày</label>
                    <input type="date" name="start_date" value="{{ $start }}" class="w-full mt-1 px-3 py-2 border rounded bg-dark-surface text-white border-dark-border">
                </div>
                <div>
                    <label class="text-gray-400 text-sm">Đến ngày</label>
                    <input type="date" name="end_date" value="{{ $end }}" class="w-full mt-1 px-3 py-2 border rounded bg-dark-surface text-white border-dark-border">
                </div>
                <div>
                    <button type="submit" class="w-full px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg transition-colors"><i class="fas fa-sync mr-2"></i>Cập nhật</button>
                </div>
            </form>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <div class="card kpi"><div class="text-xs text-gray-400 mb-1">Doanh thu</div><div class="text-2xl font-bold">₫{{ number_format($totals['revenue'], 0, ',', '.') }}</div></div>
            <div class="card kpi"><div class="text-xs text-gray-400 mb-1">Vé bán</div><div class="text-2xl font-bold">{{ $totals['tickets'] }}</div></div>
            <div class="card kpi"><div class="text-xs text-gray-400 mb-1">Clicks</div><div class="text-2xl font-bold">{{ $totals['clicks'] }}</div></div>
            <div class="card kpi"><div class="text-xs text-gray-400 mb-1">Chuyển đổi</div><div class="text-2xl font-bold">{{ $totals['interactions'] }}</div></div>
            <div class="card kpi"><div class="text-xs text-gray-400 mb-1">ROI trung bình</div><div class="text-2xl font-bold">{{ number_format($totals['avg_roi'], 2) }}%</div></div>
            <div class="card kpi"><div class="text-xs text-gray-400 mb-1">Engagement Rate</div><div class="text-2xl font-bold">{{ number_format($derived['engagement_rate'], 2) }}%</div></div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card">
                <h3 class="text-lg font-semibold text-white mb-4">Doanh thu theo thời gian</h3>
                <canvas id="revenueSeriesChart" height="160"></canvas>
            </div>
            <div class="card">
                <h3 class="text-lg font-semibold text-white mb-4">Clicks vs. Chuyển đổi</h3>
                <canvas id="engagementSeriesChart" height="160"></canvas>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="card">
            <h3 class="text-lg font-semibold text-white mb-4">Chi tiết theo ngày</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full table">
                    <thead>
                        <tr class="text-left">
                            <th class="px-3 py-2">Ngày</th>
                            <th class="px-3 py-2 text-right">Doanh thu</th>
                            <th class="px-3 py-2 text-right">Vé bán</th>
                            <th class="px-3 py-2 text-right">Clicks</th>
                            <th class="px-3 py-2 text-right">Chuyển đổi</th>
                            <th class="px-3 py-2 text-right">ROI (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Statistics::whereBetween('date', [$start, $end])->orderBy('date')->get() as $r)
                            @php($mc = (array) ($r->marketing_campaign_stats ?? []))
                            <tr class="border-t border-dark-border/50">
                                <td class="px-3 py-2">{{ optional($r->date)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 text-right">₫{{ number_format($r->revenue_today, 0, ',', '.') }}</td>
                                <td class="px-3 py-2 text-right">{{ $r->tickets_sold_today }}</td>
                                <td class="px-3 py-2 text-right">{{ (int) ($mc['clicks'] ?? 0) }}</td>
                                <td class="px-3 py-2 text-right">{{ (int) ($mc['interactions'] ?? 0) }}</td>
                                <td class="px-3 py-2 text-right">{{ number_format($r->campaign_roi, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Chart.js (only for charts; no mock data) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const labels = @json($labels);
    const revenue = @json($series['revenue']);
    const clicks = @json($series['clicks']);
    const conversions = @json($series['conversions']);

    const revCtx = document.getElementById('revenueSeriesChart').getContext('2d');
    new Chart(revCtx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Doanh thu',
                data: revenue,
                borderColor: '#22c55e',
                backgroundColor: 'rgba(34,197,94,0.15)',
                tension: .3,
                fill: true
            }]
        },
        options: { plugins: { legend: { labels: { color: '#e5e7eb' } } }, scales: { x: { ticks: { color: '#9ca3af' } }, y: { ticks: { color: '#9ca3af' } } } }
    });

    const engCtx = document.getElementById('engagementSeriesChart').getContext('2d');
    new Chart(engCtx, {
        type: 'bar',
        data: {
            labels,
            datasets: [
                { label: 'Clicks', data: clicks, backgroundColor: 'rgba(59,130,246,0.6)', borderColor: '#3b82f6' },
                { label: 'Chuyển đổi', data: conversions, backgroundColor: 'rgba(234,88,12,0.6)', borderColor: '#ea580c' }
            ]
        },
        options: { plugins: { legend: { labels: { color: '#e5e7eb' } } }, scales: { x: { ticks: { color: '#9ca3af' } }, y: { ticks: { color: '#9ca3af' } } } }
    });
</script>
</body>
</html>
