<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Báo cáo Nhân sự - NeoScreem</title>
    <script>
        (function(){
          const blockedKeywords = ['onboarding'];
          const blockedRegex = new RegExp(blockedKeywords.join('|'), 'i');
          const allowedOnboardingUrls = [ 'js/onboarding.js','neoscreem.com/onboarding' ];
          function isBlockedUrl(url){
            try {
              if (!url) return false;
              for (const allowed of allowedOnboardingUrls) { if (url.includes(allowed)) return false; }
              return url && blockedRegex.test(String(url));
            } catch(e){ return false; }
          }
          function safeWarn(){ try { console.warn.apply(console, arguments); } catch(e){} }
          try { window.createOnboardingFrame = function(){ safeWarn('🛑 BLOCKED: createOnboardingFrame()'); return false; }; } catch(e){}
          try { window.onboarding = window.onboarding || {}; ['init','start','show','load','create'].forEach(fn => { window.onboarding[fn] = function(){ safeWarn('🛑 BLOCKED: onboarding.'+fn+'()'); return false; }; }); } catch(e){}
          const origCreateElement = Document.prototype.createElement;
          Document.prototype.createElement = function(tagName){
            const el = origCreateElement.call(this, tagName);
            try {
              if (String(tagName).toLowerCase() === 'script') {
                let _src = '';
                Object.defineProperty(el, 'src', { configurable: true, enumerable: true, get(){ return _src; }, set(value){ if (isBlockedUrl(value)) { safeWarn('🛑 BLOCKED script from loading (src):', value); return; } _src = value; } });
                const origSetAttr = el.setAttribute; el.setAttribute = function(name, value){ if (name === 'src' && isBlockedUrl(value)) { safeWarn('🛑 BLOCKED script (setAttribute):', value); return; } return origSetAttr.call(this, name, value); };
              }
            } catch(e){}
            return el;
          };
          ['appendChild','insertBefore','replaceChild'].forEach(method=>{ const orig = Node.prototype[method]; Node.prototype[method] = function(node, ref){ try { if (node && node.tagName === 'SCRIPT') { const src = node.src || node.getAttribute && node.getAttribute('src'); if (isBlockedUrl(src)) { safeWarn('🛑 BLOCKED script via DOM '+method+':', src); return node; } } } catch(e){} return orig.call(this, node, ref); }; });
          const mo = new MutationObserver(muts=>{ for(const m of muts){ for(const n of m.addedNodes){ try{ if(n && n.tagName === 'SCRIPT'){ const s = n.src || (n.getAttribute && n.getAttribute('src')) || ''; if (isBlockedUrl(s)){ safeWarn('🛑 BLOCKED onboarding script (mutation):', s); if(n.parentNode) n.parentNode.removeChild(n); } } }catch(e){} } } });
          try { mo.observe(document.documentElement || document.body || document, { childList:true, subtree:true }); } catch(e){}
          try { const origFetch = window.fetch; window.fetch = function(input){ try{ const url = (typeof input === 'string') ? input : (input && input.url); if (isBlockedUrl(url)) { safeWarn('🛑 BLOCKED fetch to:', url); return new Promise((_, rej) => rej(new Error('Blocked by Onboarding Protection'))); } } catch(e){} return origFetch.apply(this, arguments); }; } catch(e){}
          try { const OrigXHR = window.XMLHttpRequest; function WrappedXHR(){ const x = new OrigXHR(); const origOpen = x.open; x.open = function(method, url){ try{ if (isBlockedUrl(url)){ safeWarn('🛑 BLOCKED XHR open to:', url); this._blocked = true; } }catch(e){} return origOpen.apply(this, arguments); }; const origSend = x.send; x.send = function(){ if (this._blocked) { safeWarn('🛑 BLOCKED XHR.send to blocked URL'); try{ this.abort && this.abort(); } catch(e){} return; } return origSend.apply(this, arguments); }; return x; } window.XMLHttpRequest = WrappedXHR; } catch(e){}
          window.addEventListener('unhandledrejection', function(event){ try { let reason = ''; if (event.reason && event.reason.message) reason = event.reason.message; else if (event.reason && event.reason.toString) reason = event.reason.toString(); else if (typeof event.reason === 'string') reason = event.reason; else if (!event.reason) reason = ''; if (reason === '' || isBlockedUrl(reason) || reason.toLowerCase().includes('onboarding') || reason.toLowerCase().includes('undefined')) { safeWarn('🛑 BLOCKED Promise rejection:', reason || event.reason); try{ event.preventDefault(); }catch(e){} } } catch(e){} }, {capture:true});
        })();
    </script>
    <link href="/favicon.svg" rel="icon" type="image/svg+xml" onerror="this.href='/favicon.ico'"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" onerror="console.warn('Font Awesome failed to load, icons may not display')">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/onboarding.js') }}"></script>
    <style>
        .bg-dark-bg { background-color: #1f2937; }
        .glass-morphism { background: rgba(26, 26, 26, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(79, 195, 247, 0.15); }
        .neon-glow { box-shadow: 0 0 15px rgba(79, 195, 247, 0.2); }
        .glow-text { color: #a5f3fc; text-shadow: 0 0 8px rgba(165, 243, 252, 0.12); animation: subtle-glow 8s ease-in-out infinite alternate; }
        @keyframes subtle-glow { 0% { text-shadow: 0 0 6px rgba(165, 243, 252, 0.1);} 100% { text-shadow: 0 0 10px rgba(165, 243, 252, 0.15);} }
        .sidebar-item { transition: all 0.3s ease; }
        .sidebar-item:hover { background: rgba(79, 195, 247, 0.08); transform: translateX(3px); }
        .sidebar-item.active { background: rgba(79, 195, 247, 0.1); border-left: 3px solid #4fd3f7; }
        .stat-card { background: rgba(26, 26, 26, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(79, 195, 247, 0.15); transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(79, 195, 247, 0.15); }
        .layout { display: flex; min-height: 100vh; }
        .background-effects { position: absolute; top:0; left:0; right:0; bottom:0; z-index:1; opacity:0.02; }
        .main-content { flex:1; position: relative; z-index: 20; min-height: 100vh; }
        .sidebar { width: 250px; background: inherit; height: 100vh; position: sticky; top: 0; z-index: 10; overflow-y: auto; }
        .chart-container { background: rgba(26, 26, 26, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(79, 195, 247, 0.15); border-radius: 0.5rem; padding: 1.5rem; }
    </style>
</head>
<body class="bg-dark-bg text-white font-sans">
    @if (session('success'))
    <div id="success-message" class="fixed top-4 right-4 glass-morphism text-green-400 p-4 rounded-lg border border-green-500/30" style="z-index: 9999;">
        {{ session('success') }}
    </div>
    @endif
    <!-- Header -->
    <header class="glass-morphism border-b border-dark-border header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-retail-green rounded-lg flex items-center justify-center">
                        <i class="fas fa-users-cog text-dark-bg text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">HR Reports</span>
                </div>
                <div class="flex-1 max-w-lg mx-8">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <form method="GET" action="{{ url('/admin/hr/reports') }}" class="block" id="hrReportsSearchForm">
                            <input type="text" name="search" id="search" class="block w-full pl-10 pr-3 py-2 border border-dark-border rounded-lg bg-dark-surface text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent" placeholder="Tìm kiếm báo cáo nhân sự..." value="{{ request('search') }}">
                        </form>
                        <div id="hrSearchSuggestions" class="absolute mt-1 left-0 right-0 bg-dark-surface border border-dark-border rounded-lg shadow-lg z-50 hidden">
                            <ul id="hrSearchSuggestionList" class="max-h-72 overflow-auto divide-y divide-dark-border"></ul>
                        </div>
                    </div>
                </div>
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
                            <a href="{{ url('/admin/hr/reports') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25">
                                <i class="fas fa-chart-bar text-retail-green"></i>
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

        <!-- Main Content -->
        <main class="main-content relative overflow-hidden" style="z-index: 1;">
            <div class="background-effects">
                <div class="absolute top-20 left-20 w-72 h-72 bg-cyan-400 rounded-full blur-xl animate-pulse"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 bg-cyan-300 rounded-full blur-xl animate-pulse" style="animation-delay: -3s;"></div>
            </div>

            <div class="p-8" style="position: relative; z-index: 10;">
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-white mb-2">Báo cáo Nhân sự</h1>
                    <p class="text-gray-400">Tổng hợp số liệu nhân sự và hiệu suất làm việc</p>
                </div>

                <!-- Bộ lọc & Tùy chỉnh -->
                <form id="topFilterForm" method="GET" action="{{ route('admin.hr.reports') }}" class="bg-dark-surface rounded-lg p-4 mb-6 border border-dark-border">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Khoảng thời gian</label>
                            <select name="range" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white">
                                <option value="month" {{ request('range','month')==='month'?'selected':'' }}>Tháng này</option>
                                <option value="week" {{ request('range')==='week'?'selected':'' }}>Tuần này</option>
                                <option value="quarter" {{ request('range')==='quarter'?'selected':'' }}>Quý này</option>
                                <option value="year" {{ request('range')==='year'?'selected':'' }}>Năm nay</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Bộ phận</label>
                            <select name="department" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white">
                                <option value="">Tất cả</option>
                                <option value="Rạp phim" {{ request('department')==='Rạp phim'?'selected':'' }}>Rạp phim</option>
                                <option value="Bán vé" {{ request('department')==='Bán vé'?'selected':'' }}>Bán vé</option>
                                <option value="Quầy bắp nước" {{ request('department')==='Quầy bắp nước'?'selected':'' }}>Quầy bắp nước</option>
                                <option value="Vệ sinh" {{ request('department')==='Vệ sinh'?'selected':'' }}>Vệ sinh</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Chức vụ</label>
                            <select name="role" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white">
                                <option value="">Tất cả</option>
                                <option value="Nhân viên" {{ request('role')==='Nhân viên'?'selected':'' }}>Nhân viên</option>
                                <option value="Tổ trưởng" {{ request('role')==='Tổ trưởng'?'selected':'' }}>Tổ trưởng</option>
                                <option value="Quản lý" {{ request('role')==='Quản lý'?'selected':'' }}>Quản lý</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <input type="hidden" name="applied" value="{{ request('applied') }}">
                            <button id="applyTop" type="submit" class="w-full px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg transition-colors">Áp dụng</button>
                            <a id="resetTop" href="{{ route('admin.hr.reports', ['reset'=>1]) }}" class="w-full px-4 py-2 border border-dark-border rounded-lg hover:bg-white/5 text-center">Xóa</a>
                        </div>
                    </div>
                </form>

                <!-- 1. Tổng quan -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="stat-card rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-blue-500/20 rounded-lg"><i class="fas fa-user-friends text-blue-400 text-lg"></i></div>
                            <div>
                                <div class="text-sm text-gray-400">Tổng nhân viên</div>
                                <div class="text-lg font-bold text-white">{{ $totalEmployees ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-green-500/20 rounded-lg"><i class="fas fa-user-plus text-green-400 text-lg"></i></div>
                            <div>
                                <div class="text-sm text-gray-400">Nhân sự mới tháng này</div>
                                <div class="text-lg font-bold text-white">{{ $newEmployeesThisMonth ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-yellow-500/20 rounded-lg"><i class="fas fa-plane-departure text-yellow-400 text-lg"></i></div>
                            <div>
                                <div class="text-sm text-gray-400">Tỷ lệ nghỉ phép</div>
                                <div class="text-lg font-bold text-white">{{ isset($leaveRate) ? $leaveRate.'%' : '0%' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card rounded-lg p-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-purple-500/20 rounded-lg"><i class="fas fa-clock text-purple-400 text-lg"></i></div>
                            <div>
                                <div class="text-sm text-gray-400">Tổng giờ làm việc</div>
                                <div class="text-lg font-bold text-white">{{ $totalWorkingHours ?? 0 }} giờ</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Biểu đồ chính -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
                    <div class="chart-container">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-semibold">Phân bổ theo bộ phận</h3>
                        </div>
                        <canvas id="deptDonut"></canvas>
                    </div>
                    <div class="chart-container lg:col-span-2">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-semibold">Xu hướng tuyển dụng (6 tháng)</h3>
                        </div>
                        <canvas id="hireLine"></canvas>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-8">
                    <div class="chart-container">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-semibold">Tỷ lệ đi làm / không đi làm</h3>
                        </div>
                        <canvas id="attendanceStack"></canvas>
                    </div>
                </div>

                <!-- 3. Báo cáo chi tiết -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-8">
                    <!-- a. Báo cáo chấm công -->
                    <div class="lg:col-span-2 glass-morphism rounded-lg p-4 border border-dark-border">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-white font-semibold">Báo cáo chấm công</h3>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.hr.reports.export.csv', request()->query()) }}" class="px-3 py-1 rounded border border-dark-border hover:bg-white/5 text-sm"><i class="fas fa-file-excel mr-1"></i>Excel</a>
                                <a href="{{ route('admin.hr.reports.export.print', request()->query()) }}" target="_blank" class="px-3 py-1 rounded border border-dark-border hover:bg-white/5 text-sm"><i class="fas fa-file-pdf mr-1"></i>PDF</a>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('admin.hr.reports') }}" class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                            <input type="month" name="month" value="{{ request('month') }}" class="py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white">
                            <select name="department" class="py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white">
                                <option value="">Bộ phận (tất cả)</option>
                                <option value="Rạp phim" {{ request('department')==='Rạp phim'?'selected':'' }}>Rạp phim</option>
                                <option value="Bán vé" {{ request('department')==='Bán vé'?'selected':'' }}>Bán vé</option>
                                <option value="Quầy bắp nước" {{ request('department')==='Quầy bắp nước'?'selected':'' }}>Quầy bắp nước</option>
                                <option value="Vệ sinh" {{ request('department')==='Vệ sinh'?'selected':'' }}>Vệ sinh</option>
                            </select>
                            <input type="text" name="employee" value="{{ request('employee') }}" placeholder="Nhân viên" class="py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white">
                        </form>
                        <div class="overflow-x-auto rounded border border-dark-border">
                            <table class="min-w-full divide-y divide-dark-border">
                                <thead class="bg-white/5">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs text-gray-400">Nhân viên</th>
                                        <th class="px-4 py-2 text-left text-xs text-gray-400">Bộ phận</th>
                                        <th class="px-4 py-2 text-left text-xs text-gray-400">Ngày</th>
                                        <th class="px-4 py-2 text-left text-xs text-gray-400">Giờ làm</th>
                                        <th class="px-4 py-2 text-left text-xs text-gray-400">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-dark-border">
                                    @forelse(($attendancePage ?? []) as $row)
                                        <tr>
                                            <td class="px-4 py-2">{{ $row->employee->name ?? '—' }}</td>
                                            <td class="px-4 py-2">{{ $row->department ?? ($row->employee->department ?? '—') }}</td>
                                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($row->date)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2">
                                                @php
                                                    try {
                                                        $start = \Carbon\Carbon::createFromFormat('H:i:s', $row->start_time);
                                                        $end = \Carbon\Carbon::createFromFormat('H:i:s', $row->end_time);
                                                        $hrs = max(0, $end->floatDiffInHours($start));
                                                    } catch (\Throwable $e) { $hrs = 0; }
                                                @endphp
                                                {{ number_format($hrs, 1) }}
                                            </td>
                                            <td class="px-4 py-2">
                                                @php $st = $row->status ?? 'Đi làm'; @endphp
                                                <span class="{{ $st==='Nghỉ phép' ? 'text-yellow-400' : 'text-green-400' }}">{{ $st }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-3 text-center text-gray-400">Không có dữ liệu</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-sm text-gray-400">
                            {{ ($attendancePage ?? null) ? $attendancePage->links() : '' }}
                        </div>
                    </div>

                    <!-- b. Báo cáo lương thưởng -->
                    <div class="glass-morphism rounded-lg p-4 border border-dark-border">
                        <h3 class="text-white font-semibold mb-3">Báo cáo lương thưởng</h3>
                        <ul class="space-y-2 text-sm">
                            <li class="flex justify-between"><span class="text-gray-400">Tổng quỹ lương (tháng)</span><span class="text-white font-semibold">₫{{ number_format($payrollBudget ?? 0, 0, ',', '.') }}</span></li>
                            <li class="flex justify-between"><span class="text-gray-400">Thưởng tháng</span><span class="text-green-400 font-semibold">₫{{ number_format($bonusTotal ?? 0, 0, ',', '.') }}</span></li>
                            <li class="flex justify-between"><span class="text-gray-400">Phạt tháng</span><span class="text-red-400 font-semibold">₫{{ number_format($penaltyTotal ?? 0, 0, ',', '.') }}</span></li>
                        </ul>
                        <div class="mt-4 text-xs text-gray-400">Chi tiết lương theo nhân viên có thể xuất Excel/PDF ở bảng chấm công.</div>
                    </div>
                </div>

                <!-- c. Báo cáo hiệu suất -->
                <div class="glass-morphism rounded-lg p-4 border border-dark-border mb-8">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-white font-semibold">Báo cáo hiệu suất</h3>
                        <div class="text-sm text-gray-400">Kỳ: Tháng này</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 rounded border border-dark-border bg-white/5">
                            <div class="text-sm text-gray-400 mb-1">Đánh giá KPI TB</div>
                            <div class="text-2xl font-bold text-white">{{ $avgKpi ?? 0 }}/100</div>
                        </div>
                        <div class="p-4 rounded border border-dark-border bg-white/5">
                            <div class="text-sm text-gray-400 mb-1">Tỷ lệ hoàn thành</div>
                            <div class="text-2xl font-bold text-white">{{ isset($completionRate) ? $completionRate.'%' : '0%' }}</div>
                        </div>
                        <div class="p-4 rounded border border-dark-border bg-white/5">
                            <div class="text-sm text-gray-400 mb-1">Nhận xét từ quản lý</div>
                            <div class="text-sm text-gray-300">{{ $managerNotes ?? 'Chưa có nhận xét.' }}</div>
                        </div>
                    </div>
                </div>

                <!-- 4. Thống kê nhanh -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="p-4 rounded-lg border border-dark-border bg-white/5">
                        <div class="text-sm text-gray-400 mb-1">Ngày nghỉ phép TB/nhân viên</div>
                        <div class="text-xl font-bold">{{ $avgLeaveDays ?? 0 }} ngày</div>
                    </div>
                    <div class="p-4 rounded-lg border border-dark-border bg-white/5">
                        <div class="text-sm text-gray-400 mb-1">Tỷ lệ đi muộn / về sớm</div>
                        <div class="text-xl font-bold">{{ isset($lateEarlyRate) ? $lateEarlyRate.'%' : '0%' }}</div>
                    </div>
                    <div class="p-4 rounded-lg border border-dark-border bg-white/5">
                        <div class="text-sm text-gray-400 mb-1">NV có giờ làm cao nhất</div>
                        <div class="text-xl font-bold">{{ $topWorkerName ?? '—' }}</div>
                    </div>
                </div>

                <!-- 6. Xuất báo cáo -->
                <div class="flex flex-wrap gap-3 mb-4">
                    <a href="{{ route('admin.hr.reports.export.csv', request()->query()) }}" class="px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg"><i class="fas fa-file-excel mr-2"></i>Xuất Excel</a>
                    <a href="{{ route('admin.hr.reports.export.print', request()->query()) }}" target="_blank" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white border border-dark-border rounded-lg"><i class="fas fa-file-pdf mr-2"></i>Xuất PDF</a>
                    <button id="openScheduleModal" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white border border-dark-border rounded-lg"><i class="fas fa-paper-plane mr-2"></i>Lập lịch gửi tự động</button>
                    <button id="openTemplateModal" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white border border-dark-border rounded-lg"><i class="fas fa-paint-brush mr-2"></i>Mẫu báo cáo</button>
                </div>

                <!-- Modals -->
                <div id="scheduleModal" class="hidden fixed inset-0 z-50 items-center justify-center">
                    <div class="absolute inset-0 bg-black/50"></div>
                    <div class="relative bg-dark-surface border border-dark-border rounded-lg w-full max-w-md p-6 z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Lập lịch gửi báo cáo</h3>
                            <button id="closeScheduleModal" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
                        </div>
                        <form method="POST" action="{{ route('admin.hr.reports.schedule') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm mb-1">Email nhận</label>
                                <input type="email" name="email" required class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white" placeholder="you@example.com">
                            </div>
                            <div>
                                <label class="block text-sm mb-1">Tần suất</label>
                                <select name="cadence" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white" required>
                                    <option value="daily">Hàng ngày</option>
                                    <option value="weekly">Hàng tuần</option>
                                    <option value="monthly">Hàng tháng</option>
                                </select>
                            </div>
                            <input type="hidden" name="range" value="{{ request('range','month') }}">
                            <input type="hidden" name="department" value="{{ request('department') }}">
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            <input type="hidden" name="month" value="{{ request('month') }}">
                            <input type="hidden" name="employee" value="{{ request('employee') }}">
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" id="cancelScheduleModal" class="px-4 py-2 border border-dark-border rounded-lg">Hủy</button>
                                <button type="submit" class="px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="templateModal" class="hidden fixed inset-0 z-50 items-center justify-center">
                    <div class="absolute inset-0 bg-black/50"></div>
                    <div class="relative bg-dark-surface border border-dark-border rounded-lg w-full max-w-md p-6 z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Lưu mẫu báo cáo</h3>
                            <button id="closeTemplateModal" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
                        </div>
                        <form method="POST" action="{{ route('admin.hr.reports.template') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm mb-1">Tên mẫu</label>
                                <input type="text" name="name" required class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white" placeholder="Báo cáo tháng">
                            </div>
                            <div>
                                <label class="block text-sm mb-1">Mô tả</label>
                                <textarea name="description" rows="3" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white" placeholder="Ghi chú..."></textarea>
                            </div>
                            <input type="hidden" name="range" value="{{ request('range','month') }}">
                            <input type="hidden" name="department" value="{{ request('department') }}">
                            <input type="hidden" name="role" value="{{ request('role') }}">
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" id="cancelTemplateModal" class="px-4 py-2 border border-dark-border rounded-lg">Hủy</button>
                                <button type="submit" class="px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        (function(){
            if (!window.Chart) return;
            const deptLabels = @json($deptLabels ?? []);
            const deptData = @json($deptData ?? []);
            const trendLabels = @json($trendLabels ?? []);
            const trendData = @json($trendData ?? []);
            const attLabels = @json($attLabels ?? []);
            const attPresent = @json($attPresent ?? []);
            const attAbsent = @json($attAbsent ?? []);

            const donut = document.getElementById('deptDonut');
            if (donut) new Chart(donut, { type:'doughnut', data:{ labels:deptLabels, datasets:[{ data:deptData, backgroundColor:['#60a5fa','#34d399','#fbbf24','#a78bfa','#f472b6','#f97316','#10b981'] }] }, options:{ plugins:{ legend:{ labels:{ color:'#e5e7eb' } } } } });

            const line = document.getElementById('hireLine');
            if (line) new Chart(line, { type:'line', data:{ labels:trendLabels, datasets:[{ label:'Tuyển mới', data:trendData, borderColor:'#34d399', tension:0.3, fill:false }] }, options:{ scales:{ x:{ ticks:{ color:'#9ca3af' } }, y:{ ticks:{ color:'#9ca3af' } } }, plugins:{ legend:{ labels:{ color:'#e5e7eb' } } } } });

            const stack = document.getElementById('attendanceStack');
            if (stack) new Chart(stack, { type:'bar', data:{ labels:attLabels, datasets:[{ label:'Đi làm', data:attPresent, backgroundColor:'#34d399' },{ label:'Không đi', data:attAbsent, backgroundColor:'#ef4444' }] }, options:{ responsive:true, scales:{ x:{ stacked:true, ticks:{ color:'#9ca3af' } }, y:{ stacked:true, ticks:{ color:'#9ca3af' } } }, plugins:{ legend:{ labels:{ color:'#e5e7eb' } } } } });
        })();
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', function(){
            // Auto hide success toast
            setTimeout(function(){ var m=document.getElementById('success-message'); if(m){ m.style.opacity='0'; setTimeout(function(){ m.remove(); }, 300); } }, 3000);

            // Set applied=1 on top filter submit
            (function(){
                var form = document.getElementById('topFilterForm');
                var apply = document.getElementById('applyTop');
                if (form && apply){
                    form.addEventListener('submit', function(){
                        var h = form.querySelector('input[name="applied"]');
                        if (!h){ h = document.createElement('input'); h.type='hidden'; h.name='applied'; form.appendChild(h); }
                        h.value = '1';
                    });
                }
            })();

            // Modal helpers
            function bindModal(openId, modalId, closeIds){
                var openBtn = document.getElementById(openId);
                var modal = document.getElementById(modalId);
                if (!modal) return;
                function open(){ modal.classList.remove('hidden'); modal.classList.add('flex'); }
                function close(){ modal.classList.add('hidden'); modal.classList.remove('flex'); }
                if (openBtn) openBtn.addEventListener('click', function(e){ e.preventDefault(); open(); });
                (closeIds||[]).forEach(function(id){ var el=document.getElementById(id); if(el) el.addEventListener('click', function(e){ e.preventDefault(); close(); }); });
                modal.addEventListener('click', function(e){ if(e.target===modal) close(); });
            }
            bindModal('openScheduleModal', 'scheduleModal', ['closeScheduleModal','cancelScheduleModal']);
            bindModal('openTemplateModal', 'templateModal', ['closeTemplateModal','cancelTemplateModal']);
        });
    </script>
</body>
</html>
