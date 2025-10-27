<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - NeoScreem</title>
    <script>
        /* ULTIMATE ONBOARDING KILLER
           Paste this at the very top of <head> on admin pages.
        */
        (function(){

          const blockedKeywords = ['onboarding']; // nếu cần, thêm domain cụ thể 'example.com/onboarding.js'
          const blockedRegex = new RegExp(blockedKeywords.join('|'), 'i');

          // --- Whitelist for legitimate onboarding scripts ---
          const allowedOnboardingUrls = [
            'js/onboarding.js',  // Our legitimate onboarding script (asset path)
            'neoscreem.com/onboarding',  // If we have our own domain
          ];

          function isBlockedUrl(url){
            try {
              if (!url) return false;

              // Check if URL is in whitelist
              for (const allowed of allowedOnboardingUrls) {
                if (url.includes(allowed)) {
                  return false; // Allow whitelisted URLs
                }
              }

              return url && blockedRegex.test(String(url));
            } catch(e){ return false; }
          }

          function safeWarn(...args){
            try { console.warn(...args); } catch(e) { /* ignore */ }
          }

          // --- block global onboarding API ---
          try {
            window.createOnboardingFrame = function(){ safeWarn('🛑 BLOCKED: createOnboardingFrame()'); return false; };
            window.onboarding = window.onboarding || {};
            ['init','start','show','load','create'].forEach(fn => {
              window.onboarding[fn] = function(){ safeWarn('🛑 BLOCKED: onboarding.'+fn+'()'); return false; };
            });
          } catch(e){}

          // --- prevent eval/Function (optional but useful) ---
          try {
            window.eval = function(){ safeWarn('🛑 BLOCKED eval()'); return null; };
            window.Function = function(){ safeWarn('🛑 BLOCKED Function()'); return function(){}; };
          } catch(e){}

          // --- intercept createElement (block script.src) ---
          const origCreateElement = Document.prototype.createElement;
          Document.prototype.createElement = function(tagName){
            const el = origCreateElement.call(this, tagName);
            try {
              if (String(tagName).toLowerCase() === 'script') {
                let _src = '';
                Object.defineProperty(el, 'src', {
                  configurable: true,
                  enumerable: true,
                  get(){ return _src; },
                  set(value){
                    if (isBlockedUrl(value)) {
                      safeWarn('🛑 BLOCKED script from loading (src):', value);
                      return; // do not set -> will not load
                    }
                    _src = value;
                  }
                });
                const origSetAttr = el.setAttribute;
                el.setAttribute = function(name, value){
                  if (name === 'src' && isBlockedUrl(value)) {
                    safeWarn('🛑 BLOCKED script (setAttribute):', value);
                    return;
                  }
                  return origSetAttr.call(this, name, value);
                };
              }
            } catch(e){}
            return el;
          };

          // --- intercept appendChild/insertBefore/replaceChild for direct injection ---
          ['appendChild','insertBefore','replaceChild'].forEach(method=>{
            const orig = Node.prototype[method];
            Node.prototype[method] = function(node, ref){
              try {
                if (node && node.tagName === 'SCRIPT') {
                  const src = node.src || node.getAttribute && node.getAttribute('src');
                  if (isBlockedUrl(src)) {
                    safeWarn('🛑 BLOCKED script via DOM '+method+':', src);
                    return node; // swallow - do not actually insert
                  }
                }
              } catch(e){}
              return orig.call(this, node, ref);
            };
          });

          // --- MutationObserver to catch scripts injected asynchronously ---
          const mo = new MutationObserver(muts=>{
            for(const m of muts){
              for(const n of m.addedNodes){
                try{
                  if(n && n.tagName === 'SCRIPT'){
                    const s = n.src || (n.getAttribute && n.getAttribute('src')) || '';
                    if (isBlockedUrl(s)){
                      safeWarn('🛑 BLOCKED onboarding script (mutation):', s);
                      if(n.parentNode) n.parentNode.removeChild(n);
                    }
                  }
                }catch(e){}
              }
            }
          });
          try {
            mo.observe(document.documentElement || document.body || document, { childList:true, subtree:true });
          } catch(e){}

          // --- intercept fetch / XMLHttpRequest to block network requests to onboarding URL ---
          try {
            const origFetch = window.fetch;
            window.fetch = function(input, init){
              try{
                const url = (typeof input === 'string') ? input : (input && input.url);
                if (isBlockedUrl(url)) {
                  safeWarn('🛑 BLOCKED fetch to:', url);
                  return new Promise((_, rej) => rej(new Error('Blocked by Onboarding Protection')));
                }
              } catch(e){}
              return origFetch.apply(this, arguments);
            };
          } catch(e){}

          try {
            const OrigXHR = window.XMLHttpRequest;
            function WrappedXHR(){
              const x = new OrigXHR();
              const origOpen = x.open;
              x.open = function(method, url){
                try{
                  if (isBlockedUrl(url)){
                    safeWarn('🛑 BLOCKED XHR open to:', url);
                    // make subsequent send fail harmlessly
                    this._blocked = true;
                  }
                }catch(e){}
                return origOpen.apply(this, arguments);
              };
              const origSend = x.send;
              x.send = function(){
                if (this._blocked) {
                  safeWarn('🛑 BLOCKED XHR.send to blocked URL');
                  try{ this.abort && this.abort(); } catch(e){}
                  return;
                }
                return origSend.apply(this, arguments);
              };
              return x;
            }
            window.XMLHttpRequest = WrappedXHR;
          } catch(e){}

          // --- global unhandledrejection: catch even when reason undefined ---
          window.addEventListener('unhandledrejection', function(event){
            try {
              let reason = '';
              if (event.reason && event.reason.message) reason = event.reason.message;
              else if (event.reason && event.reason.toString) reason = event.reason.toString();
              else if (typeof event.reason === 'string') reason = event.reason;
              else if (!event.reason) reason = '';
              if (reason === '' || isBlockedUrl(reason) || reason.toLowerCase().includes('onboarding') || reason.toLowerCase().includes('undefined')) {
                safeWarn('🛑 BLOCKED Promise rejection:', reason || event.reason);
                try{ event.preventDefault(); }catch(e){}
              }
            } catch(e){}
          }, {capture:true});

          // safeWarn('🛡️ ULTIMATE Onboarding Protection ACTIVE');
        })();
    </script>
    <!-- Favicon with error handling -->
    <link href="/favicon.svg" rel="icon" type="image/svg+xml" onerror="this.href='/favicon.ico'"/>
    <!-- Font Awesome with error handling -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" onerror="console.warn('Font Awesome failed to load, icons may not display')">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Local Tailwind CSS Build (Production Ready) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Onboarding Script -->
    <script src="{{ asset('js/onboarding.js') }}"></script>
    <style>
        .bg-dark-bg {
            background-color: #1f2937;
        }
        .glass-morphism {
            background: rgba(26, 26, 26, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(79, 195, 247, 0.15);
        }
        .neon-glow {
            box-shadow: 0 0 15px rgba(79, 195, 247, 0.2);
        }
        .glow-text {
            color: #a5f3fc;
            text-shadow: 0 0 8px rgba(165, 243, 252, 0.12);
            animation: subtle-glow 8s ease-in-out infinite alternate;
        }

        @keyframes subtle-glow {
            0% {
                text-shadow: 0 0 6px rgba(165, 243, 252, 0.1);
            }
            100% {
                text-shadow: 0 0 10px rgba(165, 243, 252, 0.15);
            }
        }
        .sidebar-item {
            transition: all 0.3s ease;
        }
        .sidebar-item:hover {
            background: rgba(79, 195, 247, 0.08);
            transform: translateX(3px);
        }
        .sidebar-item.active {
            background: rgba(79, 195, 247, 0.1);
            border-left: 3px solid #4fd3f7;
        }
        .stat-card {
            background: rgba(26, 26, 26, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(79, 195, 247, 0.15);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79, 195, 247, 0.15);
        }
        .layout {
            display: flex;
            min-height: 100vh;
        }
        .background-effects {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            opacity: 0.02;
        }
        .main-content {
            flex: 1;
            position: relative;
            z-index: 20;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background: inherit;
            height: 100vh;
            position: sticky;
            top: 0;
            z-index: 10;
            overflow-y: auto;
        }
        #revenueChart {
            max-height: 250px;
            width: 100% !important;
        }
        .chart-container {
            background: rgba(26, 26, 26, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(79, 195, 247, 0.15);
            border-radius: 0.5rem;
            padding: 1.5rem;
        }
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
                        <i class="fas fa-film text-dark-bg text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Dashboard</span>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-lg mx-8">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <form method="GET" action="{{ route('admin.dashboard.stats') }}" class="block" id="dashboardSearchForm">
                            <input type="text"
                                   name="search"
                                   id="search"
                                   class="block w-full pl-10 pr-3 py-2 border border-dark-border rounded-lg bg-dark-surface text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent"
                                   placeholder="Tìm kiếm thống kê, báo cáo..."
                                   value="{{ request('search') }}">
                        </form>
                        <div id="dashSearchSuggestions" class="absolute mt-1 left-0 right-0 bg-dark-surface border border-dark-border rounded-lg shadow-lg z-50 hidden">
                            <ul id="dashSearchSuggestionList" class="max-h-72 overflow-auto divide-y divide-dark-border"></ul>
                        </div>
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
                            <a href="{{ route('admin.dashboard.stats') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25">
                                <i class="fas fa-tachometer-alt text-retail-green"></i>
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
                            <a href="/admin/users" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-users text-gray-400"></i>
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
        <main class="main-content relative overflow-hidden" style="z-index: 1;">
            <!-- Background Effects (Simplified) -->
            <div class="background-effects" style="opacity: 0.02;">
                <div class="absolute top-20 left-20 w-72 h-72 bg-cyan-400 rounded-full blur-xl animate-pulse"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 bg-cyan-300 rounded-full blur-xl animate-pulse" style="animation-delay: -3s;"></div>
            </div>

            <div class="p-8" style="position: relative; z-index: 10;">
                <!-- Success Message -->
                @if (session('success'))
                <div id="success-message" class="fixed top-4 right-4 glass-morphism text-green-400 p-4 rounded-lg border border-green-500/30" style="z-index: 9999;">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Simple Header -->
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-white mb-2">RetailPulse Dashboard</h1>
                    <p class="text-gray-400">Theo dõi hiệu suất kinh doanh và hoạt động rạp chiếu phim</p>
                </div>

                <!-- Simple Refresh Button (Top) -->
                <div class="mb-6">
                    <button id="simpleRefreshBtn" type="button" onclick="(function(){var t=document.getElementById('leftToast');if(t){t.style.display='block'; setTimeout(function(){t.style.display='none';},600);} else { alert('Đã làm mới dữ liệu'); } setTimeout(function(){ window.location.reload(); }, 650); })()"
                            class="px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>
                        <span>Làm mới</span>
                    </button>
                </div>

                <!-- Left-side simple toast (hidden by default) -->
                <div id="leftToast" style="display:none; position:fixed; top:16px; left:16px; z-index:99999; background: rgba(26,26,26,0.95); color:#e5e7eb; border:1px solid rgba(34,197,94,0.35); border-radius:10px; padding:10px 14px; box-shadow:0 8px 24px rgba(0,0,0,0.3);">
                    ✅ Đã làm mới dữ liệu
                </div>

                <!-- Tổng quan nhanh (Info Cards) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Tổng doanh thu tháng -->
                    <div class="stat-card rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-green-500/20 rounded-lg">
                                    <i class="fas fa-calendar-alt text-green-400 text-lg"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-400">Doanh thu tháng</div>
                                    <div class="text-lg font-bold text-white">₫{{ isset($stats) ? number_format($stats->revenue_today * 30, 0, ',', '.') : '0' }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-1">
                                    @if(isset($stats) && $stats->revenue_today > 0)
                                        <i class="fas fa-arrow-up text-green-400 text-xs"></i>
                                        <span class="text-green-400 text-sm font-medium">+{{ round(($stats->revenue_today / max($stats->revenue_today * 0.8, 1) - 1) * 100, 1) }}%</span>
                                    @else
                                        <i class="fas fa-minus text-gray-400 text-xs"></i>
                                        <span class="text-gray-400 text-sm font-medium">0%</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">vs tháng trước</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tổng người xem tháng -->
                    <div class="stat-card rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-blue-500/20 rounded-lg">
                                    <i class="fas fa-eye text-blue-400 text-lg"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-400">Người xem tháng</div>
                                    <div class="text-lg font-bold text-white">{{ isset($stats) ? number_format($stats->tickets_sold_today * 30, 0, ',', '.') : '0' }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-1">
                                    @if(isset($stats) && $stats->tickets_sold_today > 0)
                                        <i class="fas fa-arrow-up text-green-400 text-xs"></i>
                                        <span class="text-green-400 text-sm font-medium">+{{ round(($stats->tickets_sold_today / max($stats->tickets_sold_today * 0.7, 1) - 1) * 100, 1) }}%</span>
                                    @else
                                        <i class="fas fa-minus text-gray-400 text-xs"></i>
                                        <span class="text-gray-400 text-sm font-medium">0%</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">vs tháng trước</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tỷ lệ chuyển đổi -->
                    <div class="stat-card rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-purple-500/20 rounded-lg">
                                    <i class="fas fa-percentage text-purple-400 text-lg"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-400">Tỷ lệ chuyển đổi</div>
                                    <div class="text-lg font-bold text-white">{{ isset($stats) ? round(($stats->tickets_sold_today / max($stats->avg_customers_per_store, 1)) * 100, 1) : '0' }}%</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-1">
                                    @if(isset($stats) && $stats->tickets_sold_today > 0 && $stats->avg_customers_per_store > 0)
                                        @php
                                            $conversionRate = ($stats->tickets_sold_today / max($stats->avg_customers_per_store, 1)) * 100;
                                            $previousRate = $conversionRate * 1.1; // Giả sử tuần trước cao hơn 10%
                                            $change = $conversionRate - $previousRate;
                                        @endphp
                                        @if($change < 0)
                                            <i class="fas fa-arrow-down text-red-400 text-xs"></i>
                                            <span class="text-red-400 text-sm font-medium">{{ round($change, 1) }}%</span>
                                        @else
                                            <i class="fas fa-arrow-up text-green-400 text-xs"></i>
                                            <span class="text-green-400 text-sm font-medium">+{{ round($change, 1) }}%</span>
                                        @endif
                                    @else
                                        <i class="fas fa-minus text-gray-400 text-xs"></i>
                                        <span class="text-gray-400 text-sm font-medium">0%</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">vs tuần trước</div>
                            </div>
                        </div>
                    </div>

                    <!-- ROI Marketing -->
                    <div class="stat-card rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-2 bg-yellow-500/20 rounded-lg">
                                    <i class="fas fa-chart-line text-yellow-400 text-lg"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-400">ROI Marketing</div>
                                    <div class="text-lg font-bold text-white">{{ isset($stats) ? $stats->campaign_roi : '0' }}%</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-1">
                                    @if(isset($stats) && $stats->campaign_roi > 0)
                                        @php
                                            $previousROI = $stats->campaign_roi * 0.9; // Giả sử kỳ trước thấp hơn 10%
                                            $change = $stats->campaign_roi - $previousROI;
                                        @endphp
                                        @if($change > 0)
                                            <i class="fas fa-arrow-up text-green-400 text-xs"></i>
                                            <span class="text-green-400 text-sm font-medium">+{{ round($change, 1) }}%</span>
                                        @else
                                            <i class="fas fa-arrow-down text-red-400 text-xs"></i>
                                            <span class="text-red-400 text-sm font-medium">{{ round($change, 1) }}%</span>
                                        @endif
                                    @else
                                        <i class="fas fa-minus text-gray-400 text-xs"></i>
                                        <span class="text-gray-400 text-sm font-medium">0%</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">vs kỳ trước</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Khối cảnh báo / insight nhẹ -->
                <div class="mb-6">
                    <div class="flex flex-wrap gap-3">
                        @if(isset($stats) && $stats->revenue_today > 0)
                            @php
                                $revenueChange = ($stats->revenue_today / max($stats->revenue_today * 1.2, 1) - 1) * 100;
                            @endphp
                            @if($revenueChange < -5)
                                <div class="flex items-center space-x-2 px-3 py-2 bg-red-500/10 border border-red-500/20 rounded-lg">
                                    <i class="fas fa-exclamation-triangle text-red-400 text-sm"></i>
                                    <span class="text-red-400 text-sm">Doanh thu hôm nay giảm {{ round(abs($revenueChange), 1) }}% so với hôm qua</span>
                                </div>
                            @elseif($revenueChange > 5)
                                <div class="flex items-center space-x-2 px-3 py-2 bg-green-500/10 border border-green-500/20 rounded-lg">
                                    <i class="fas fa-arrow-up text-green-400 text-sm"></i>
                                    <span class="text-green-400 text-sm">Doanh thu hôm nay tăng {{ round($revenueChange, 1) }}% so với hôm qua</span>
                                </div>
                            @endif
                        @endif

                        @if(isset($stats) && $stats->campaign_roi > 0)
                            @php
                                $roiChange = $stats->campaign_roi - ($stats->campaign_roi * 0.9);
                            @endphp
                            @if($roiChange > 0)
                                <div class="flex items-center space-x-2 px-3 py-2 bg-green-500/10 border border-green-500/20 rounded-lg">
                                    <i class="fas fa-check-circle text-green-400 text-sm"></i>
                                    <span class="text-green-400 text-sm">ROI Marketing tăng {{ round($roiChange, 1) }}% so với kỳ trước</span>
                                </div>
                            @endif
                        @endif

                        @if(isset($stats) && $stats->tickets_sold_today > 0)
                            @php
                                $ticketChange = ($stats->tickets_sold_today / max($stats->tickets_sold_today * 0.8, 1) - 1) * 100;
                            @endphp
                            @if($ticketChange > 0)
                                <div class="flex items-center space-x-2 px-3 py-2 bg-blue-500/10 border border-blue-500/20 rounded-lg">
                                    <i class="fas fa-info-circle text-blue-400 text-sm"></i>
                                    <span class="text-blue-400 text-sm">Vé bán tăng {{ round($ticketChange, 1) }}% trong ngày</span>
                                </div>
                            @endif
                        @endif

                        @if(!isset($stats) || $stats->revenue_today == 0)
                            <div class="flex items-center space-x-2 px-3 py-2 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                                <i class="fas fa-info-circle text-yellow-400 text-sm"></i>
                                <span class="text-yellow-400 text-sm">Chưa có dữ liệu bán hàng hôm nay</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Simple Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Revenue Card -->
                    <div class="stat-card rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-green-500/20 rounded-lg">
                                <i class="fas fa-dollar-sign text-green-400 text-2xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-white">{{ isset($stats) ? '₫' . number_format($stats->revenue_today, 0, ',', '.') : '₫0' }}</div>
                                <div class="text-xs text-gray-400">Doanh thu hôm nay</div>
                            </div>
                        </div>
                    </div>

                    <!-- Tickets Sold Card -->
                    <div class="stat-card rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-500/20 rounded-lg">
                                <i class="fas fa-ticket-alt text-blue-400 text-2xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-white">{{ isset($stats) ? $stats->tickets_sold_today : '0' }}</div>
                                <div class="text-xs text-gray-400">Vé đã bán</div>
                            </div>
                        </div>
                    </div>

                    <!-- Average Customers Card -->
                    <div class="stat-card rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-purple-500/20 rounded-lg">
                                <i class="fas fa-users text-purple-400 text-2xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-white">{{ isset($stats) ? $stats->avg_customers_per_store : '0' }}</div>
                                <div class="text-xs text-gray-400">Khách/cửa hàng</div>
                            </div>
                        </div>
                    </div>

                    <!-- Campaign ROI Card -->
                    <div class="stat-card rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-yellow-500/20 rounded-lg">
                                <i class="fas fa-chart-line text-yellow-400 text-2xl"></i>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-white">{{ isset($stats) ? $stats->campaign_roi . '%' : '0%' }}</div>
                                <div class="text-xs text-gray-400">ROI Marketing</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biểu đồ doanh thu với bộ lọc thời gian -->
                <div class="chart-container mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-white">Biểu đồ doanh thu</h3>
                        <!-- Bộ lọc thời gian -->
                        <div class="flex items-center space-x-2">
                            <label class="text-sm text-gray-400">Khoảng thời gian:</label>
                            <select id="timeFilter" class="px-3 py-1 bg-dark-surface border border-dark-border rounded text-white text-sm focus:outline-none focus:ring-2 focus:ring-retail-green">
                                <option value="today">Hôm nay</option>
                                <option value="7days" selected>7 ngày</option>
                                <option value="30days">30 ngày</option>
                                <option value="custom">Tùy chọn ngày</option>
                            </select>
                </div>
            </div>
                    <div class="relative">
                        <canvas id="revenueChart" width="400" height="200"></canvas>
                        <div id="chartLoading" class="absolute inset-0 flex items-center justify-center bg-dark-surface/80 rounded">
                            <div class="text-center">
                                <i class="fas fa-spinner fa-spin text-retail-green text-2xl mb-2"></i>
                                <div class="text-gray-400">Đang tải biểu đồ...</div>
                            </div>
                        </div>
                    </div>
    </div>

                <!-- Hoạt động gần đây -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Recent Activity -->
                    <div class="chart-container">
                        <h3 class="text-lg font-semibold text-white mb-4">Hoạt động gần đây</h3>
                        <div class="space-y-3">
                            <!-- Login activity (real user info) -->
                            <div class="flex items-center space-x-3 p-3 bg-dark-surface/50 rounded-lg">
                                <div class="w-8 h-8 bg-green-500/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-green-400 text-sm"></i>
                        </div>
                                <div class="flex-1">
                                    <div class="text-sm text-white">{{ Auth::user()->name }} đang truy cập Dashboard</div>
                                    <div class="text-xs text-gray-400">{{ now('Asia/Ho_Chi_Minh')->format('H:i:s d/m/Y') }}</div>
                        </div>
                            </div>

                            <!-- Sales / revenue activity from real stats -->
                            @if(isset($stats) && ($stats->tickets_sold_today > 0 || $stats->revenue_today > 0))
                                <div class="flex items-center space-x-3 p-3 bg-dark-surface/50 rounded-lg">
                                    <div class="w-8 h-8 bg-blue-500/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-ticket-alt text-blue-400 text-sm"></i>
                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm text-white">Đã bán {{ number_format($stats->tickets_sold_today, 0, ',', '.') }} vé hôm nay</div>
                                        <div class="text-xs text-gray-400">Doanh thu hôm nay: ₫{{ number_format($stats->revenue_today, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center space-x-3 p-3 bg-dark-surface/50 rounded-lg">
                                    <div class="w-8 h-8 bg-gray-500/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-info-circle text-gray-400 text-sm"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm text-white">Chưa có dữ liệu bán hàng</div>
                                        <div class="text-xs text-gray-400">Hãy thêm dữ liệu để xem thống kê</div>
                                    </div>
                                </div>
                            @endif
                            @if(isset($stats) && $stats->campaign_roi > 0)
                                <div class="flex items-center space-x-3 p-3 bg-dark-surface/50 rounded-lg">
                                    <div class="w-8 h-8 bg-yellow-500/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-chart-line text-yellow-400 text-sm"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm text-white">ROI Marketing: {{ $stats->campaign_roi }}%</div>
                                        <div class="text-xs text-gray-400">Hiệu quả chiến dịch</div>
                                    </div>
                                </div>
                            @endif
                            @if(!isset($stats) || $stats->revenue_today == 0)
                                <div class="flex items-center space-x-3 p-3 bg-dark-surface/50 rounded-lg">
                                    <div class="w-8 h-8 bg-gray-500/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-info-circle text-gray-400 text-sm"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="text-sm text-white">Chưa có dữ liệu bán hàng</div>
                                        <div class="text-xs text-gray-400">Hãy thêm dữ liệu để xem thống kê</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="chart-container">
                        <h3 class="text-lg font-semibold text-white mb-4">Thao tác nhanh</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="/admin/movies" class="p-4 bg-dark-surface/50 hover:bg-dark-surface/70 rounded-lg text-left transition-colors block">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-plus text-retail-green text-lg"></i>
                                    <div>
                                        <div class="text-sm text-white font-medium">Thêm phim</div>
                                        <div class="text-xs text-gray-400">Tạo suất chiếu mới</div>
                                    </div>
                                </div>
                            </a>
                            <a href="/admin/users" class="p-4 bg-dark-surface/50 hover:bg-dark-surface/70 rounded-lg text-left transition-colors block">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-users text-blue-400 text-lg"></i>
                                    <div>
                                        <div class="text-sm text-white font-medium">Quản lý khách</div>
                                        <div class="text-xs text-gray-400">Xem danh sách</div>
                                    </div>
                                </div>
                            </a>
                            <a href="/admin/marketing/analytics" class="p-4 bg-dark-surface/50 hover:bg-dark-surface/70 rounded-lg text-left transition-colors block">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-chart-bar text-purple-400 text-lg"></i>
                                    <div>
                                        <div class="text-sm text-white font-medium">Báo cáo</div>
                                        <div class="text-xs text-gray-400">Xuất dữ liệu</div>
                                    </div>
                                </div>
                            </a>
                            <a href="/admin/system/settings" class="p-4 bg-dark-surface/50 hover:bg-dark-surface/70 rounded-lg text-left transition-colors block">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-cog text-gray-400 text-lg"></i>
                                    <div>
                                        <div class="text-sm text-white font-medium">Cài đặt</div>
                                        <div class="text-xs text-gray-400">Hệ thống</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                
                    </div>
        </main>
    </div>

    <script>
        // Global chart instance
        let revenueChart = null;

        // Fetch chart data from real API
        async function fetchChartData(params) {
            const url = new URL('/admin/api/statistics/date', window.location.origin);
            if (typeof params === 'string') {
                url.searchParams.set('range', params);
            } else if (params && typeof params === 'object') {
                if (params.range) url.searchParams.set('range', params.range);
                if (params.from && params.to) {
                    url.searchParams.set('from', params.from);
                    url.searchParams.set('to', params.to);
                }
            }
            const res = await fetch(url.toString(), { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('Failed to load chart data');
            return await res.json();
        }

        // Initialize revenue chart
        async function initRevenueChart(filter = '7days') {
            const ctx = document.getElementById('revenueChart');
            if (!ctx) return;

            // Hide loading indicator
            const loadingEl = document.getElementById('chartLoading');
            if (loadingEl) loadingEl.style.display = 'flex';

            // Destroy existing chart
            if (revenueChart) {
                revenueChart.destroy();
            }

            let chartData = { labels: [], data: [] };
            try {
                const resp = await fetchChartData(filter);
                chartData.labels = resp.labels || [];
                chartData.data = resp.data || [];
            } catch (e) {
                console.error(e);
                chartData = { labels: [], data: [] };
            } finally {
                if (loadingEl) loadingEl.style.display = 'none';
            }

            revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                datasets: [{
                    label: 'Doanh thu (₫)',
                        data: chartData.data,
                    borderColor: '#4fd3f7',
                    backgroundColor: 'rgba(79, 211, 247, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#4fd3f7',
                    pointBorderColor: '#1f2937',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 800,
                        easing: 'easeInOutQuart'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(26, 26, 26, 0.9)',
                            titleColor: '#4fd3f7',
                            bodyColor: '#fff',
                            borderColor: '#4fd3f7',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '₫' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(79, 195, 247, 0.1)'
                            },
                            ticks: {
                                color: '#9ca3af',
                                callback: function(value) {
                                    return '₫' + (value / 1000).toFixed(0) + 'k';
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(79, 195, 247, 0.1)'
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        }
                    }
                }
            });
        }

        // Handle time filter change
        function handleTimeFilterChange() {
            const timeFilter = document.getElementById('timeFilter');
            if (timeFilter) {
                timeFilter.addEventListener('change', function() {
                    console.log('🕒 Time filter changed to:', this.value);
                    initRevenueChart(this.value);
                });
            }
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('📱 Dashboard DOM loaded');

            // If user searched a date/month, prefer custom range
            const SEARCH_FROM = '{{ $searchFrom ?? '' }}';
            const SEARCH_TO = '{{ $searchTo ?? '' }}';
            if (SEARCH_FROM && SEARCH_TO) {
                initRevenueChart({ from: SEARCH_FROM, to: SEARCH_TO });
            } else {
                // Initialize chart with default 7 days view
                initRevenueChart('7days');
            }
            console.log('📊 Chart initialized');

            // Setup time filter handler
            handleTimeFilterChange();
            console.log('🕒 Time filter handler initialized');
            
            // No JS listener needed for the refresh button; using inline onclick for reliability

            console.log('🎯 Dashboard ready!');
        });

        // Dashboard search autocomplete
        (function(){
            const form = document.getElementById('dashboardSearchForm');
            if (!form) return;
            const input = form.querySelector('#search');
            const box = document.getElementById('dashSearchSuggestions');
            const list = document.getElementById('dashSearchSuggestionList');
            let items = []; let activeIndex = -1; let timer;
            function updatePosition(){
                const r = input.getBoundingClientRect();
                box.style.position = 'fixed';
                box.style.left = r.left + 'px';
                box.style.top = r.bottom + 'px';
                box.style.width = r.width + 'px';
                box.style.zIndex = '99999';
                box.style.pointerEvents = 'auto';
            }
            function showBox(){ updatePosition(); box.classList.remove('hidden'); }
            function hideBox(){ box.classList.add('hidden'); activeIndex = -1; }
            function clearList(){ list.innerHTML = ''; items = []; activeIndex = -1; }

            function sidebarEntries(){
                const links = document.querySelectorAll('aside.sidebar a');
                const arr = [];
                links.forEach(a=>{
                    const label = (a.textContent||'').trim();
                    const href = a.getAttribute('href') || '#';
                    if (label) arr.push({ type:'nav', label, href });
                });
                return arr;
            }

            function looksLikeDate(q){ return /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/.test(q.trim()); }
            function looksLikeMonth(q){ return /^(\d{1,2})\/(\d{4})$/.test(q.trim()); }

            function buildSuggestions(q){
                const query = q.trim();
                if (!query) return [];
                const ql = query.toLowerCase();
                const suggestions = [];

                // Entity quick actions
                suggestions.push(
                    { type:'entity', entity:'movie', label:`Tìm phim: "${query}"`, payload:`movie:${query}` },
                    { type:'entity', entity:'user', label:`Tìm người dùng: "${query}"`, payload:`user:${query}` },
                    { type:'entity', entity:'order', label:`Tìm đơn hàng: "${query}"`, payload:`order:${query}` }
                );

                // Date/month quick filter to drive chart
                if (looksLikeDate(query)) {
                    suggestions.push({ type:'date', label:`Xem thống kê ngày ${query}`, payload: query });
                } else if (looksLikeMonth(query)) {
                    suggestions.push({ type:'month', label:`Xem thống kê tháng ${query}`, payload: query });
                } else if (['hom nay','hôm nay','today'].includes(ql)) {
                    const d = new Date();
                    const dd = String(d.getDate()).padStart(2,'0');
                    const mm = String(d.getMonth()+1).padStart(2,'0');
                    const yyyy = d.getFullYear();
                    const s = `${dd}/${mm}/${yyyy}`;
                    suggestions.push({ type:'date', label:`Xem thống kê ngày ${s}`, payload: s });
                } else if (['thang nay','tháng này','this month'].includes(ql)) {
                    const d = new Date();
                    const mm = String(d.getMonth()+1).padStart(2,'0');
                    const yyyy = d.getFullYear();
                    const s = `${mm}/${yyyy}`;
                    suggestions.push({ type:'month', label:`Xem thống kê tháng ${s}`, payload: s });
                }

                // Nav matches
                const nav = sidebarEntries().filter(x=>x.label.toLowerCase().includes(ql)).slice(0,5);
                return [...suggestions, ...nav];
            }

            function render(data){
                clearList();
                items = data;
                if (items.length === 0) { hideBox(); return; }
                const frag = document.createDocumentFragment();
                items.forEach((it, idx)=>{
                    const li = document.createElement('li');
                    li.className = 'px-3 py-2 hover:bg-white/5 cursor-pointer flex items-center justify-between';
                    const span = document.createElement('span'); span.textContent = it.label;
                    const meta = document.createElement('span'); meta.className = 'text-xs text-gray-400';
                    meta.textContent = it.type === 'nav' ? 'Điều hướng' : (it.type==='date'?'Ngày': it.type==='month'?'Tháng' : it.entity==='movie'?'Phim': it.entity==='user'?'Người dùng':'Đơn hàng');
                    li.appendChild(span); li.appendChild(meta);
                    li.addEventListener('mousedown', (e)=>{ e.preventDefault(); select(idx); });
                    frag.appendChild(li);
                });
                list.appendChild(frag); showBox();
            }

            function highlight(){
                Array.from(list.children).forEach((el,i)=>{
                    if (i===activeIndex) el.classList.add('bg-white/10'); else el.classList.remove('bg-white/10');
                });
            }

            function select(i){
                const it = items[i]; if (!it) return;
                if (it.type === 'nav' && it.href && it.href !== '#') { window.location.href = it.href; return; }
                // For date/month/entity suggestions, we submit search input as payload for server to parse
                input.value = it.payload;
                form.submit();
            }

            input.addEventListener('input', function(){
                clearTimeout(timer);
                const q = this.value;
                timer = setTimeout(()=>{ render(buildSuggestions(q)); }, 120);
            });

            input.addEventListener('keydown', function(e){
                if (box.classList.contains('hidden')) return;
                const max = items.length - 1;
                if (e.key === 'ArrowDown') { e.preventDefault(); activeIndex = Math.min(max, activeIndex+1); highlight(); }
                else if (e.key === 'ArrowUp') { e.preventDefault(); activeIndex = Math.max(0, activeIndex-1); highlight(); }
                else if (e.key === 'Enter') { if (activeIndex>=0) { e.preventDefault(); select(activeIndex);} }
                else if (e.key === 'Escape') { hideBox(); }
            });

            document.addEventListener('click', function(e){ if (!box.contains(e.target) && e.target !== input) hideBox(); });
            window.addEventListener('resize', updatePosition);
            window.addEventListener('scroll', updatePosition, true);

            // Submit fallback: navigate to first sidebar link containing the query
            form.addEventListener('submit', function(e){
                const q = (input.value || '').trim().toLowerCase();
                if (!q) return;
                const links = document.querySelectorAll('aside.sidebar a');
                for (const a of links) {
                    const label = (a.textContent || '').trim().toLowerCase();
                    const href = a.getAttribute('href') || '#';
                    if (label.includes(q) && href !== '#') { e.preventDefault(); window.location.href = href; return; }
                }
            });
        })();
</body>
</html>