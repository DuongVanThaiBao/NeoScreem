<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - NeoScreem</title>
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
            background-color: #1f2937; /* Optimized dark gray instead of pure black */
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
        /* Optimized animations for better performance */
        .animate-fade {
            animation: fade 4s ease-in-out infinite;
        }
        .animate-slow-pulse {
            animation: slow-pulse 6s ease-in-out infinite;
        }
        .animate-subtle-glow {
            animation: subtle-glow 5s ease-in-out infinite alternate;
        }

        @keyframes fade {
            0%, 100% { opacity: 0.03; }
            50% { opacity: 0.06; }
        }

        @keyframes slow-pulse {
            0%, 100% { opacity: 0.04; transform: scale(1); }
            50% { opacity: 0.08; transform: scale(1.01); }
        }

        @keyframes subtle-glow {
            0% { box-shadow: 0 0 6px rgba(165, 243, 252, 0.08); }
            100% { box-shadow: 0 0 12px rgba(165, 243, 252, 0.12); }
        }

        /* Performance optimizations */
        .animate-float {
            will-change: transform;
        }
        .blur-xl {
            filter: blur(24px); /* More efficient than blur-3xl */
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
        .header {
            position: sticky;
            top: 0;
            z-index: 30;
            backdrop-filter: blur(10px);
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
        .main-content {
            flex: 1;
            position: relative;
            z-index: 20;
            min-height: 100vh;
        }
        .chart-container {
            background: rgba(26, 26, 26, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(79, 195, 247, 0.1);
            position: relative;
            z-index: 15;
        }
        .stat-card {
            background: rgba(26, 26, 26, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(79, 195, 247, 0.15);
            transition: all 0.3s ease;
            position: relative;
            z-index: 15;
        }
    </style>
</head>
<body class="bg-dark-bg text-white font-sans">
    @if (session('success'))
    <div id="success-message" class="fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-[9999]">
        <div class="flex items-center space-x-2">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif
    <!-- Header -->
    <header class="glass-morphism border-b border-dark-border header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-retail-green rounded-lg flex items-center justify-center">
                        <i class="fas fa-film text-dark-bg text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Admin</span>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-lg mx-8">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <form method="GET" action="{{ route('admin.admin') }}" class="block" id="adminSearchForm">
                            <input type="text"
                                   name="search"
                                   id="search"
                                   class="block w-full pl-10 pr-3 py-2 border border-dark-border rounded-lg bg-dark-surface text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent"
                                   placeholder="Tìm kiếm phim, người dùng, đơn hàng..."
                                   value="{{ request('search') }}">
                        </form>
                        <!-- Autocomplete dropdown -->
                        <div id="searchSuggestions" class="absolute mt-1 left-0 right-0 bg-dark-surface border border-dark-border rounded-lg shadow-lg z-40 hidden">
                            <ul id="searchSuggestionList" class="max-h-72 overflow-auto divide-y divide-dark-border"></ul>
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
                            <a href="{{ route('admin.admin') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25">
                                <i class="fas fa-home text-retail-green"></i>
                                <span class="font-medium">Trang chủ</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dashboard.stats') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
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
                            <a href="/admin/marketing/campaigns" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-bullhorn text-gray-400"></i>
                                <span>Chiến dịch marketing</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/marketing/analytics" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-chart-pie text-gray-400"></i>
                                <span>Phân tích hiệu quả</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/marketing/targets" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
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
                            <a href="/admin/hr/employees" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-users text-gray-400"></i>
                                <span>Quản lý nhân sự</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/hr/schedules" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-calendar-check text-gray-400"></i>
                                <span>Lịch làm việc</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/hr/reports" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
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
                            <a href="/admin/system/settings" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-cog text-gray-400"></i>
                                <span>Cài đặt hệ thống</span>
                            </a>
                        </li>
                        <li>
                            <a href="/admin/system/security" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
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
        <main class="main-content relative overflow-hidden flex items-center justify-center">
            <!-- Background Effects -->
            <div class="background-effects">
                <div class="absolute top-20 left-20 w-72 h-72 bg-cyan-400 rounded-full blur-xl animate-fade"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 bg-cyan-300 rounded-full blur-xl animate-fade" style="animation-delay: -3s;"></div>
            </div>

            <div class="p-8">

                <!-- Main Greeting - Perfectly Centered with top spacing -->
                <div class="animate-float">
                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-medium text-cyan-100 mb-8 glow-text animate-subtle-glow mt-64">
                        Xin chào Admin
                    </h1>
                    <div class="w-96 h-96 mx-auto relative">
                        <div class="absolute inset-0 border-2 border-cyan-400/15 rounded-full animate-spin opacity-10" style="animation-duration: 12s;"></div>
                        <div class="absolute inset-4 border border-cyan-300/10 rounded-full animate-slow-pulse opacity-15"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-32 h-32 bg-gradient-to-br from-cyan-400/15 via-cyan-300/10 to-transparent rounded-full animate-fade"></div>
                        </div>
                        <!-- Modern accent dots -->
                        <div class="absolute -top-6 -right-6 w-10 h-10 border-2 border-cyan-400/25 rounded-full flex items-center justify-center">
                            <div class="w-3 h-3 bg-cyan-300 rounded-full animate-fade"></div>
                        </div>
                        <div class="absolute -bottom-6 -left-6 w-8 h-8 border border-cyan-300/20 rounded-full flex items-center justify-center">
                            <div class="w-2 h-2 bg-cyan-400 rounded-full animate-fade" style="animation-delay: -1s;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <script>
        // Auto-hide success message after 3 seconds
        setTimeout(() => {
            const successMsg = document.getElementById('success-message');
            if (successMsg) {
                successMsg.style.opacity = '0';
                setTimeout(() => successMsg.remove(), 300);
            }
        }, 3000);
        (function(){
            const form = document.getElementById('adminSearchForm');
            if (!form) return;
            const input = form.querySelector('#search');
            const box = document.getElementById('searchSuggestions');
            const list = document.getElementById('searchSuggestionList');
            let items = [];
            let activeIndex = -1;

            function showBox(){ box.classList.remove('hidden'); }
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

            function buildSuggestions(q){
                const query = q.trim();
                if (!query) return [];
                const ql = query.toLowerCase();
                const nav = sidebarEntries().filter(x=>x.label.toLowerCase().includes(ql)).slice(0,5);
                const entities = [
                    { type:'entity', entity:'movie', label:`Tìm phim: "${query}"`, payload: `movie:${query}` },
                    { type:'entity', entity:'user', label:`Tìm người dùng: "${query}"`, payload: `user:${query}` },
                    { type:'entity', entity:'order', label:`Tìm đơn hàng: "${query}"`, payload: `order:${query}` },
                ];
                return [...entities, ...nav];
            }

            function render(itemsData){
                clearList();
                items = itemsData;
                if (items.length === 0){ hideBox(); return; }
                const frag = document.createDocumentFragment();
                items.forEach((it, idx)=>{
                    const li = document.createElement('li');
                    li.className = 'px-3 py-2 hover:bg-white/5 cursor-pointer flex items-center justify-between';
                    const span = document.createElement('span');
                    span.textContent = it.label;
                    const meta = document.createElement('span');
                    meta.className = 'text-xs text-gray-400';
                    meta.textContent = it.type === 'nav' ? 'Điều hướng' : (it.entity === 'movie' ? 'Phim' : it.entity === 'user' ? 'Người dùng' : 'Đơn hàng');
                    li.appendChild(span); li.appendChild(meta);
                    li.addEventListener('mousedown', (e)=>{ e.preventDefault(); select(idx); });
                    frag.appendChild(li);
                });
                list.appendChild(frag);
                showBox();
            }

            function highlight(){
                Array.from(list.children).forEach((el,i)=>{
                    if (i === activeIndex) el.classList.add('bg-white/10'); else el.classList.remove('bg-white/10');
                });
            }

            function select(i){
                const it = items[i]; if (!it) return;
                if (it.type === 'nav' && it.href && it.href !== '#') {
                    window.location.href = it.href; return;
                }
                if (it.type === 'entity') {
                    input.value = it.payload;
                    form.submit(); return;
                }
            }

            let timer;
            input.addEventListener('input', function(){
                clearTimeout(timer);
                const q = this.value;
                timer = setTimeout(()=>{
                    const data = buildSuggestions(q);
                    render(data);
                }, 120);
            });

            input.addEventListener('keydown', function(e){
                if (box.classList.contains('hidden')) return;
                const max = items.length - 1;
                if (e.key === 'ArrowDown') { e.preventDefault(); activeIndex = Math.min(max, activeIndex + 1); highlight(); }
                else if (e.key === 'ArrowUp') { e.preventDefault(); activeIndex = Math.max(0, activeIndex - 1); highlight(); }
                else if (e.key === 'Enter') {
                    if (activeIndex >= 0) { e.preventDefault(); select(activeIndex); }
                } else if (e.key === 'Escape') { hideBox(); }
            });

            document.addEventListener('click', function(e){
                if (!box.contains(e.target) && e.target !== input) hideBox();
            });

            form.addEventListener('submit', function(e){
                const q = (form.querySelector('#search')?.value || '').trim().toLowerCase();
                if (!q) return;
                const links = document.querySelectorAll('aside.sidebar a');
                let target = null;
                for (const a of links) {
                    const label = (a.textContent || '').trim().toLowerCase();
                    if (label.includes(q)) { target = a; break; }
                }
                if (target && target.getAttribute('href') && target.getAttribute('href') !== '#') {
                    e.preventDefault();
                    window.location.href = target.getAttribute('href');
                }
            });
        })();
    </script>
