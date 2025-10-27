<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý nhân sự - NeoScreem</title>
    <script>
        (function(){
          const blockedKeywords = ['onboarding'];
          const blockedRegex = new RegExp(blockedKeywords.join('|'), 'i');
          const allowedOnboardingUrls = ['js/onboarding.js','neoscreem.com/onboarding'];
          function isBlockedUrl(url){ try{ if(!url) return false; for(const a of allowedOnboardingUrls){ if(url.includes(a)) return false; } return blockedRegex.test(String(url)); }catch(e){ return false; } }
          function safeWarn(){ try{ console.warn.apply(console, arguments); }catch(e){} }
          try{ window.createOnboardingFrame=function(){safeWarn('🛑 BLOCKED: createOnboardingFrame()');return false}; window.onboarding=window.onboarding||{}; ['init','start','show','load','create'].forEach(fn=>{ window.onboarding[fn]=function(){safeWarn('🛑 BLOCKED: onboarding.'+fn+'()'); return false}; }); }catch(e){}
          try{ window.eval=function(){safeWarn('🛑 BLOCKED eval()'); return null}; window.Function=function(){safeWarn('🛑 BLOCKED Function()'); return function(){} }; }catch(e){}
          const origCreateElement = Document.prototype.createElement; Document.prototype.createElement=function(tag){ const el = origCreateElement.call(this, tag); try{ if(String(tag).toLowerCase()==='script'){ let _src=''; Object.defineProperty(el,'src',{configurable:true,enumerable:true,get(){return _src;},set(v){ if(isBlockedUrl(v)){ safeWarn('🛑 BLOCKED script (src):',v); return; } _src=v; }}); const o=el.setAttribute; el.setAttribute=function(n,v){ if(n==='src'&&isBlockedUrl(v)){ safeWarn('🛑 BLOCKED script (setAttribute):',v); return; } return o.call(this,n,v); }; } }catch(e){} return el; };
          ['appendChild','insertBefore','replaceChild'].forEach(m=>{ const o=Node.prototype[m]; Node.prototype[m]=function(n,r){ try{ if(n&&n.tagName==='SCRIPT'){ const s=n.src||n.getAttribute&&n.getAttribute('src'); if(isBlockedUrl(s)){ safeWarn('🛑 BLOCKED script via DOM '+m+':',s); return n; } } }catch(e){} return o.call(this,n,r); } });
          const mo=new MutationObserver(ms=>{ for(const m of ms){ for(const n of m.addedNodes){ try{ if(n&&n.tagName==='SCRIPT'){ const s=n.src||(n.getAttribute&&n.getAttribute('src'))||''; if(isBlockedUrl(s)){ safeWarn('🛑 BLOCKED onboarding script (mutation):',s); if(n.parentNode) n.parentNode.removeChild(n); } } }catch(e){} } } }); try{ mo.observe(document.documentElement||document.body||document,{childList:true,subtree:true}); }catch(e){}
          try{ const of=window.fetch; window.fetch=function(i,init){ try{ const u=(typeof i==='string')?i:(i&&i.url); if(isBlockedUrl(u)){ safeWarn('🛑 BLOCKED fetch to:',u); return new Promise((_,rej)=>rej(new Error('Blocked by Onboarding Protection'))); } }catch(e){} return of.apply(this,arguments); }; }catch(e){}
          try{ const O=window.XMLHttpRequest; function W(){ const x=new O(); const oo=x.open; x.open=function(m,u){ try{ if(isBlockedUrl(u)){ safeWarn('🛑 BLOCKED XHR open to:',u); this._blocked=true; } }catch(e){} return oo.apply(this,arguments); }; const os=x.send; x.send=function(){ if(this._blocked){ safeWarn('🛑 BLOCKED XHR.send to blocked URL'); try{ this.abort&&this.abort(); }catch(e){} return; } return os.apply(this,arguments); }; return x; } window.XMLHttpRequest=W; }catch(e){}
          window.addEventListener('unhandledrejection',function(ev){ try{ let r=''; if(ev.reason&&ev.reason.message) r=ev.reason.message; else if(ev.reason&&ev.reason.toString) r=ev.reason.toString(); else if(typeof ev.reason==='string') r=ev.reason; else if(!ev.reason) r=''; if(r===''||isBlockedUrl(r)||String(r).toLowerCase().includes('onboarding')||String(r).toLowerCase().includes('undefined')){ safeWarn('🛑 BLOCKED Promise rejection:',r||ev.reason); try{ ev.preventDefault(); }catch(e){} } }catch(e){} },{capture:true});
        })();
    </script>
    <link href="/favicon.svg" rel="icon" type="image/svg+xml" onerror="this.href='/favicon.ico'"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" onerror="console.warn('Font Awesome failed to load')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/onboarding.js') }}"></script>
    <style>
        .bg-dark-bg{background-color:#1f2937}
        .glass-morphism{background:rgba(26,26,26,0.8);backdrop-filter:blur(10px);border:1px solid rgba(79,195,247,0.15)}
        .layout{display:flex;min-height:100vh}
        .header{position:sticky;top:0;z-index:30;backdrop-filter:blur(10px)}
        .sidebar{width:250px;background:inherit;height:100vh;position:sticky;top:0;z-index:10;overflow-y:auto}
        .main-content{flex:1;position:relative;z-index:20;min-height:100vh}
        .stat-card{background:rgba(26,26,26,0.8);backdrop-filter:blur(10px);border:1px solid rgba(79,195,247,0.15);transition:all .3s ease}
        .status-pill{padding:.25rem .5rem;border-radius:.375rem;font-size:.75rem;font-weight:600;display:inline-block}
        .status-active{background-color:rgba(34,197,94,.15);color:#86efac;border:1px solid rgba(34,197,94,.35)}
        .status-inactive{background-color:rgba(239,68,68,.15);color:#fca5a5;border:1px solid rgba(239,68,68,.35)}
    </style>
</head>
<body class="bg-dark-bg text-white font-sans">
    @if (session('success'))
    <div id="success-message" class="fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-[9999]">
        <div class="flex items-center space-x-2"><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
    </div>
    @endif
    <header class="glass-morphism border-b border-dark-border header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-retail-green rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-dark-bg text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Quản lý nhân sự</span>
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
                            <a href="{{ route('admin.admin') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors">
                                <i class="fas fa-home text-gray-400"></i>
                                <span>Trang chủ</span>
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
                            <a href="/admin/hr/employees" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25">
                                <i class="fas fa-users text-retail-green"></i>
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

        <main class="main-content relative overflow-hidden">
            <div class="p-8" style="position: relative; z-index: 10;">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-white">Danh sách nhân viên</h1>
                    <a href="{{ route('admin.hr.employees.create') }}" class="px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Thêm nhân viên
                    </a>
                </div>

                <form method="GET" action="{{ route('admin.hr.employees.index') }}" class="bg-dark-surface rounded-lg p-4 mb-6 border border-dark-border">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Tìm kiếm</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-search text-gray-400"></i></div>
                                <input name="q" value="{{ $q ?? request('q') }}" id="empSearch" type="text" class="block w-full pl-10 pr-3 py-2 border border-dark-border rounded-lg bg-dark-surface text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent" placeholder="Tên/Mã NV">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Bộ phận</label>
                            <select name="department" id="empDept" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent">
                                <option value="">Tất cả</option>
                                @foreach(($departments ?? ['Rạp phim','Bán vé','Quầy bắp nước','Vệ sinh']) as $d)
                                    <option value="{{ $d }}" {{ (($department ?? request('department')) == $d) ? 'selected' : '' }}>{{ $d }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Trạng thái</label>
                            <select name="status" id="empStatus" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent">
                                <option value="">Tất cả</option>
                                @foreach(($statuses ?? ['Đang làm','Nghỉ việc']) as $s)
                                    <option value="{{ $s }}" {{ (($status ?? request('status')) == $s) ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="w-full px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg transition-colors">Lọc</button>
                            <a href="{{ route('admin.hr.employees.index') }}" class="w-full px-4 py-2 border border-dark-border rounded-lg hover:bg-white/5 text-center">Xóa lọc</a>
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto bg-dark-surface rounded-lg border border-dark-border">
                    <table class="min-w-full divide-y divide-dark-border">
                        <thead class="bg-white/5">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nhân viên</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Mã NV</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Họ tên</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Bộ phận</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">SĐT</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Trạng thái</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody id="empTable" class="divide-y divide-dark-border">
                            @forelse($employees as $e)
                            <tr class="emp-row">
                                <td class="px-4 py-3">
                                    <img src="{{ $e->avatar ?? 'https://i.pravatar.cc/80' }}" alt="{{ $e->name }}" class="w-8 h-8 rounded-full object-cover">
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-300">{{ $e->code }}</td>
                                <td class="px-4 py-3 text-sm text-white">{{ $e->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-300">{{ $e->department }}</td>
                                <td class="px-4 py-3 text-sm text-gray-300">{{ $e->phone }}</td>
                                <td class="px-4 py-3">
                                    @if(($e->status ?? 'Đang làm') === 'Đang làm')
                                        <span class="status-pill status-active">Đang làm</span>
                                    @else
                                        <span class="status-pill status-inactive">Nghỉ việc</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.hr.employees.show', $e) }}" class="px-3 py-2 text-sm bg-white/10 hover:bg-white/15 rounded-lg">Chi tiết</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-400">Chưa có nhân viên nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex items-center justify-between text-sm text-gray-400">
                    <div>Hiển thị <span id="empCount">{{ $employees->total() }}</span> nhân viên</div>
                    <div class="space-x-2">{{ $employees->withQueryString()->links() }}</div>
                </div>
            </div>
        </main>
    </div>

    <script>
        setTimeout(function(){ var m=document.getElementById('success-message'); if(m){ m.style.opacity='0'; setTimeout(function(){ m.remove(); }, 300); } }, 3000);
    </script>
</body>
</html>
