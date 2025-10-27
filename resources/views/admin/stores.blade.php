<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý cửa hàng - NeoScreem</title>
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
        .header {
            position: relative;
            z-index: 100;
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
        .form-container {
            background: rgba(26, 26, 26, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(79, 195, 247, 0.15);
            border-radius: 0.5rem;
            padding: 2rem;
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
                        <i class="fas fa-store text-dark-bg text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Quản lý cửa hàng</span>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-lg mx-8">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <form method="GET" action="{{ url('/admin/stores') }}" class="block" id="storeSearchForm">
                            <input type="text"
                                   name="search"
                                   id="store_search"
                                   class="block w-full pl-10 pr-3 py-2 border border-dark-border rounded-lg bg-dark-surface text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent"
                                   placeholder="Tìm kiếm thông tin cửa hàng..."
                                   value="{{ request('search') }}">
                        </form>
                        <!-- Autocomplete dropdown -->
                        <div id="storeSearchSuggestions" class="absolute mt-1 left-0 right-0 bg-dark-surface border border-dark-border rounded-lg shadow-lg hidden" style="z-index: 9999;">
                            <ul id="storeSearchSuggestionList" class="max-h-72 overflow-auto divide-y divide-dark-border"></ul>
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
                            <a href="/admin/stores" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25">
                                <i class="fas fa-store text-retail-green"></i>
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

                <!-- Header -->
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-white mb-2">Quản lý cửa hàng</h1>
                    <p class="text-gray-400">Cập nhật thông tin cửa hàng và hãng phim</p>
                </div>

                <!-- Store Information Form -->
                <div class="form-container">
                    <form method="POST" action="{{ route('admin.stores.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Store Basic Information -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Store Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">
                                    <i class="fas fa-store text-retail-green mr-2"></i>
                                    Tên cửa hàng / Hãng phim
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ $store['name'] }}"
                                       class="w-full px-4 py-3 bg-dark-surface border border-dark-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent transition-colors"
                                       placeholder="Nhập tên cửa hàng..."
                                       required>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-300 mb-2">
                                    <i class="fas fa-phone text-retail-green mr-2"></i>
                                    Số điện thoại liên hệ
                                </label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ $store['phone'] }}"
                                       class="w-full px-4 py-3 bg-dark-surface border border-dark-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent transition-colors"
                                       placeholder="Nhập số điện thoại..."
                                       required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-map-marker-alt text-retail-green mr-2"></i>
                                Địa chỉ chi nhánh
                            </label>
                            <input type="text" 
                                   id="address" 
                                   name="address" 
                                   value="{{ $store['address'] }}"
                                   class="w-full px-4 py-3 bg-dark-surface border border-dark-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent transition-colors"
                                   placeholder="Nhập địa chỉ chi nhánh..."
                                   required>
                        </div>

                        <!-- Opening Hours -->
                        <div>
                            <label for="opening_hours" class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-clock text-retail-green mr-2"></i>
                                Giờ mở cửa / Lịch chiếu phim
                            </label>
                            <input type="text" 
                                   id="opening_hours" 
                                   name="opening_hours" 
                                   value="{{ $store['opening_hours'] }}"
                                   class="w-full px-4 py-3 bg-dark-surface border border-dark-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent transition-colors"
                                   placeholder="Ví dụ: 8:00 - 23:00 (Hàng ngày)"
                                   required>
                        </div>

                        <!-- Additional Information -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                                    <i class="fas fa-envelope text-retail-green mr-2"></i>
                                    Email liên hệ
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ $store['email'] }}"
                                       class="w-full px-4 py-3 bg-dark-surface border border-dark-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent transition-colors"
                                       placeholder="Nhập email..."
                                       required>
                            </div>

                            <!-- Website -->
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-300 mb-2">
                                    <i class="fas fa-globe text-retail-green mr-2"></i>
                                    Website
                                </label>
                                <input type="url" 
                                       id="website" 
                                       name="website" 
                                       value="{{ $store['website'] }}"
                                       class="w-full px-4 py-3 bg-dark-surface border border-dark-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent transition-colors"
                                       placeholder="Nhập website...">
                            </div>

                            <!-- Capacity -->
                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-300 mb-2">
                                    <i class="fas fa-users text-retail-green mr-2"></i>
                                    Sức chứa
                                </label>
                                <input type="number" 
                                       id="capacity" 
                                       name="capacity" 
                                       value="{{ $store['capacity'] }}"
                                       class="w-full px-4 py-3 bg-dark-surface border border-dark-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent transition-colors"
                                       placeholder="Nhập sức chứa..."
                                       min="1"
                                       required>
                            </div>
                        </div>

                        <!-- Screens -->
                        <div>
                            <label for="screens" class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-tv text-retail-green mr-2"></i>
                                Số phòng chiếu
                            </label>
                            <input type="number" 
                                   id="screens" 
                                   name="screens" 
                                   value="{{ $store['screens'] }}"
                                   class="w-full px-4 py-3 bg-dark-surface border border-dark-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent transition-colors"
                                   placeholder="Nhập số phòng chiếu..."
                                   min="1"
                                   required>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-300 mb-2">
                                <i class="fas fa-info-circle text-retail-green mr-2"></i>
                                Mô tả ngắn về cửa hàng / hãng phim
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4"
                                      class="w-full px-4 py-3 bg-dark-surface border border-dark-border rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent transition-colors resize-none"
                                      placeholder="Nhập mô tả về cửa hàng..."
                                      required>{{ $store['description'] }}</textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-dark-border">
                            <button type="button" 
                                    onclick="resetForm()"
                                    class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors">
                                <i class="fas fa-undo mr-2"></i>
                                Đặt lại
                            </button>
                            <button type="submit" 
                                    class="px-6 py-3 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Store Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <!-- Total Capacity -->
                    <div class="stat-card rounded-lg p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-3 bg-blue-500/20 rounded-lg">
                                    <i class="fas fa-users text-blue-400 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-400">Tổng sức chứa</div>
                                    <div class="text-2xl font-bold text-white">{{ number_format($store['capacity']) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Screens -->
                    <div class="stat-card rounded-lg p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-3 bg-green-500/20 rounded-lg">
                                    <i class="fas fa-tv text-green-400 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-400">Số phòng chiếu</div>
                                    <div class="text-2xl font-bold text-white">{{ $store['screens'] }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Average per Screen -->
                    <div class="stat-card rounded-lg p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="p-3 bg-purple-500/20 rounded-lg">
                                    <i class="fas fa-calculator text-purple-400 text-2xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-400">Sức chứa/phòng</div>
                                    <div class="text-2xl font-bold text-white">{{ number_format($store['capacity'] / $store['screens']) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Auto-hide success message after 3 seconds
        setTimeout(() => {
            const successMsg = document.getElementById('success-message');
            if (successMsg) {
                successMsg.style.opacity = '0';
                setTimeout(() => successMsg.remove(), 300);
            }
        }, 3000);

        // Reset form function
        function resetForm() {
            if (confirm('Bạn có chắc chắn muốn đặt lại tất cả thông tin về giá trị ban đầu?')) {
                document.querySelector('form').reset();
            }
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['name', 'address', 'phone', 'opening_hours', 'description', 'email', 'capacity', 'screens'];
            let isValid = true;

            requiredFields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ các trường bắt buộc!');
            }
        });

        // Remove error styling on input
        document.querySelectorAll('input, textarea').forEach(field => {
            field.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });
        });
    </script>
</body>
</html>
<script>
(function(){
  const form = document.getElementById('storeSearchForm'); if (!form) return;
  const input = document.getElementById('store_search');
  const box = document.getElementById('storeSearchSuggestions');
  const list = document.getElementById('storeSearchSuggestionList');
  let items = [], activeIndex = -1, timer;
  function updatePosition(){
    const r = input.getBoundingClientRect();
    box.style.position = 'fixed';
    box.style.left = r.left + 'px';
    box.style.top = (r.bottom) + 'px';
    box.style.width = r.width + 'px';
    box.style.zIndex = '99999';
    box.style.pointerEvents = 'auto';
  }
  function showBox(){ updatePosition(); box.classList.remove('hidden'); }
  function hideBox(){ box.classList.add('hidden'); activeIndex = -1; }
  function clearList(){ list.innerHTML = ''; items = []; activeIndex = -1; }
  function sidebarEntries(){ const arr=[]; document.querySelectorAll('aside.sidebar a').forEach(a=>{ const label=(a.textContent||'').trim(); const href=a.getAttribute('href')||'#'; if(label) arr.push({type:'nav',label,href});}); return arr; }
  function buildSuggestions(q){ const query=q.trim(); if(!query) return []; const ql=query.toLowerCase(); const nav=sidebarEntries().filter(x=>x.label.toLowerCase().includes(ql)).slice(0,5); const ents=[{type:'entity',entity:'store',label:`Tìm cửa hàng: "${query}"`,payload:`store:${query}`}]; return [...ents,...nav]; }
  function render(data){ clearList(); items=data; if(items.length===0){ hideBox(); return;} const frag=document.createDocumentFragment(); items.forEach((it,idx)=>{ const li=document.createElement('li'); li.className='px-3 py-2 hover:bg-white/5 cursor-pointer flex items-center justify-between'; const span=document.createElement('span'); span.textContent=it.label; const meta=document.createElement('span'); meta.className='text-xs text-gray-400'; meta.textContent= it.type==='nav'?'Điều hướng': 'Cửa hàng'; li.appendChild(span); li.appendChild(meta); li.addEventListener('mousedown',e=>{ e.preventDefault(); select(idx);}); frag.appendChild(li);}); list.appendChild(frag); showBox(); }
  function highlight(){ Array.from(list.children).forEach((el,i)=>{ if(i===activeIndex) el.classList.add('bg-white/10'); else el.classList.remove('bg-white/10');}); }
  function select(i){ const it=items[i]; if(!it) return; if(it.type==='nav' && it.href && it.href!=='#'){ window.location.href=it.href; return;} input.value=it.payload; form.submit(); }
  input.addEventListener('input', function(){ clearTimeout(timer); const q=this.value; timer=setTimeout(()=>{ render(buildSuggestions(q)); }, 120); });
  input.addEventListener('keydown', function(e){ if(box.classList.contains('hidden')) return; const max=items.length-1; if(e.key==='ArrowDown'){ e.preventDefault(); activeIndex=Math.min(max, activeIndex+1); highlight(); } else if(e.key==='ArrowUp'){ e.preventDefault(); activeIndex=Math.max(0, activeIndex-1); highlight(); } else if(e.key==='Enter'){ if(activeIndex>=0){ e.preventDefault(); select(activeIndex);} } else if(e.key==='Escape'){ hideBox(); }});
  document.addEventListener('click', function(e){ if(!box.contains(e.target) && e.target!==input) hideBox(); });
  window.addEventListener('resize', updatePosition);
  window.addEventListener('scroll', updatePosition, true);
  form.addEventListener('submit', function(e){ const q=(input.value||'').trim().toLowerCase(); if(!q) return; const links=document.querySelectorAll('aside.sidebar a'); for(const a of links){ const label=(a.textContent||'').trim().toLowerCase(); const href=a.getAttribute('href')||'#'; if(label.includes(q) && href!=='#'){ e.preventDefault(); window.location.href=href; return; } }
  });
})();
</script>
