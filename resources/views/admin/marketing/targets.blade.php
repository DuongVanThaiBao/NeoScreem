<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Target khách hàng - NeoScreem</title>
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
    </style>
</head>
<body class="bg-dark-bg text-white font-sans">
<header class="glass-morphism border-b border-dark-border header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-retail-green rounded-lg flex items-center justify-center">
                    <i class="fas fa-bullseye text-dark-bg text-lg"></i>
                </div>
                <span class="text-xl font-bold text-white">Target khách hàng</span>
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
                    <li><a href="{{ route('admin.marketing.analytics') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-chart-line text-gray-400"></i><span>Phân tích hiệu quả</span></a></li>
                    <li><a href="{{ route('admin.marketing.targets') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25"><i class="fas fa-bullseye text-retail-green"></i><span>Target khách hàng</span></a></li>
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
        <!-- Demographics -->
        <div class="card">
            <h3 class="text-lg font-semibold text-white mb-4">Phân tích nhân khẩu học</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div>
                    <div class="text-sm text-gray-400 mb-2">Phân bố độ tuổi</div>
                    <canvas id="ageChart" height="140"></canvas>
                </div>
                <div>
                    <div class="text-sm text-gray-400 mb-2">Giới tính</div>
                    <canvas id="genderChart" height="140"></canvas>
                </div>
                <div>
                    <div class="text-sm text-gray-400 mb-2">Thể loại ưa thích</div>
                    <canvas id="genreChart" height="140"></canvas>
                </div>
            </div>
        </div>

        <!-- Behavior -->
        <div class="card">
            <h3 class="text-lg font-semibold text-white mb-4">Hành vi người dùng</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div>
                    <div class="text-sm text-gray-400 mb-2">Khung giờ xem yêu thích</div>
                    <canvas id="timePrefChart" height="140"></canvas>
                </div>
                <div>
                    <div class="text-sm text-gray-400 mb-2">Kênh mua vé</div>
                    <canvas id="channelChart" height="140"></canvas>
                </div>
                <div>
                    <div class="text-sm text-gray-400 mb-2">Phân khúc chi tiêu</div>
                    <canvas id="spendTierChart" height="140"></canvas>
                </div>
            </div>
        </div>

        <!-- Segmentation & Tools -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card">
                <h3 class="text-lg font-semibold text-white mb-4">Phân khúc khách hàng</h3>
                <ul class="space-y-2 text-gray-300 text-sm">
                    <li>• Khách hàng thân thiết (≥ 5 vé/tháng)</li>
                    <li>• Khách mới (lần đầu đặt vé)</li>
                    <li>• Khách ngủ đông (> 3 tháng chưa quay lại)</li>
                    <li>• Nhóm tuỳ chỉnh (lọc theo điều kiện)</li>
                </ul>
            </div>
            <div class="card">
                <h3 class="text-lg font-semibold text-white mb-4">Công cụ tạo chiến dịch</h3>
                <form class="space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm text-gray-400">Độ tuổi</label>
                            <select class="w-full mt-1 px-3 py-2 border rounded bg-dark-surface text-white border-dark-border">
                                <option value="">Tất cả</option>
                                <option>13-17</option>
                                <option>18-24</option>
                                <option>25-34</option>
                                <option>35-44</option>
                                <option>45+</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-400">Giới tính</label>
                            <select class="w-full mt-1 px-3 py-2 border rounded bg-dark-surface text-white border-dark-border">
                                <option value="">Tất cả</option>
                                <option>Nam</option>
                                <option>Nữ</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-400">Kênh mua vé</label>
                            <select class="w-full mt-1 px-3 py-2 border rounded bg-dark-surface text-white border-dark-border">
                                <option value="">Tất cả</option>
                                <option>Website</option>
                                <option>Ứng dụng</option>
                                <option>Quầy vé</option>
                                <option>Đối tác</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-400">Chi tiêu</label>
                            <select class="w-full mt-1 px-3 py-2 border rounded bg-dark-surface text-white border-dark-border">
                                <option value="">Tất cả</option>
                                <option>VIP</option>
                                <option>Thường xuyên</option>
                                <option>Mới</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg">Tạo nhóm mục tiêu</button>
                        <button type="button" class="ml-2 px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg">Xuất danh sách</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Suggestions -->
        <div class="card">
            <h3 class="text-lg font-semibold text-white mb-2">Gợi ý tối ưu</h3>
            <ul class="list-disc pl-6 text-gray-300 text-sm space-y-1">
                <li>Thời điểm tốt nhất: dựa trên khung giờ xem yêu thích và tỉ lệ chuyển đổi.</li>
                <li>Nội dung phù hợp: đề xuất thể loại/phim sắp chiếu theo từng nhóm.</li>
                <li>Kênh tối ưu: khuyến nghị kênh có CPA thấp nhất cho từng phân khúc.</li>
            </ul>
        </div>
    </main>
</div>

<!-- Chart.js (datasets sẽ bind từ controller khi tích hợp thật) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const darkTicks = { color: '#9ca3af' };
const legend = { labels: { color: '#e5e7eb' } };

const ageLabels = @json($ageLabels ?? []);
const ageData = @json($ageData ?? []);
new Chart(document.getElementById('ageChart'), {
  type: 'bar',
  data: { labels: ageLabels, datasets: [{ label: 'Số KH', data: ageData, backgroundColor: 'rgba(59,130,246,0.6)' }] },
  options: { plugins: legend, scales: { x: { ticks: darkTicks }, y: { ticks: darkTicks } } }
});

const genderLabels = @json($genderLabels ?? []);
const genderData = @json($genderData ?? []);
new Chart(document.getElementById('genderChart'), { type: 'doughnut', data: { labels: genderLabels, datasets: [{ data: genderData, backgroundColor: ['#22c55e','#3b82f6','#eab308'] }] }, options: { plugins: legend } });

const genreLabels = @json($genreLabels ?? []);
const genreData = @json($genreData ?? []);
new Chart(document.getElementById('genreChart'), {
  type: 'bar',
  data: { labels: genreLabels, datasets: [{ label: 'Đơn đặt', data: genreData, backgroundColor: 'rgba(234,88,12,0.6)' }] },
  options: { plugins: legend, scales: { x: { ticks: darkTicks }, y: { ticks: darkTicks } } }
});

const timeLabels = @json($timeLabels ?? []);
const timeData = @json($timeData ?? []);
new Chart(document.getElementById('timePrefChart'), {
  type: 'line',
  data: { labels: timeLabels, datasets: [{ label: 'Đơn theo giờ', data: timeData, borderColor: '#22c55e', backgroundColor: 'rgba(34,197,94,0.15)', fill: true, tension: .3 }] },
  options: { plugins: legend, scales: { x: { ticks: darkTicks }, y: { ticks: darkTicks } } }
});

const channelLabels = @json($channelLabels ?? []);
const channelData = @json($channelData ?? []);
new Chart(document.getElementById('channelChart'), { type: 'bar', data: { labels: channelLabels, datasets: [{ label: 'Số đơn', data: channelData, backgroundColor: 'rgba(99,102,241,0.6)' }] }, options: { plugins: legend, scales: { x: { ticks: darkTicks }, y: { ticks: darkTicks } } }});

const spendLabels = @json($spendLabels ?? []);
const spendData = @json($spendData ?? []);
new Chart(document.getElementById('spendTierChart'), { type: 'bar', data: { labels: spendLabels, datasets: [{ label: 'Số KH', data: spendData, backgroundColor: 'rgba(14,165,233,0.6)' }] }, options: { plugins: legend, scales: { x: { ticks: darkTicks }, y: { ticks: darkTicks } } }});
</script>
</body>
</html>
