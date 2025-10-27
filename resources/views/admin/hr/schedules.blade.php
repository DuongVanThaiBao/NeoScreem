<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lịch làm việc - NeoScreem</title>
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
                        <i class="fas fa-calendar-check text-dark-bg text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Lịch làm việc</span>
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
                            <a href="{{ route('admin.admin') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ Route::currentRouteName()==='admin.admin' ? 'text-white bg-retail-green/10 border border-retail-green/25' : 'text-gray-300 hover:text-white hover:bg-retail-green/10' }} transition-colors">
                                <i class="fas fa-home {{ Route::currentRouteName()==='admin.admin' ? 'text-retail-green' : 'text-gray-400' }}"></i>
                                <span>Trang chủ</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.dashboard.stats') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ Route::currentRouteName()==='admin.dashboard.stats' ? 'text-white bg-retail-green/10 border border-retail-green/25' : 'text-gray-300 hover:text-white hover:bg-retail-green/10' }} transition-colors">
                                <i class="fas fa-tachometer-alt {{ Route::currentRouteName()==='admin.dashboard.stats' ? 'text-retail-green' : 'text-gray-400' }}"></i>
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
                            <a href="{{ route('admin.hr.employees.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ str_starts_with(Route::currentRouteName(),'admin.hr.employees') ? 'text-white bg-retail-green/10 border border-retail-green/25' : 'text-gray-300 hover:text-white hover:bg-retail-green/10' }} transition-colors">
                                <i class="fas fa-users {{ str_starts_with(Route::currentRouteName(),'admin.hr.employees') ? 'text-retail-green' : 'text-gray-400' }}"></i>
                                <span>Quản lý nhân sự</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.hr.schedules') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ Route::currentRouteName()==='admin.hr.schedules' ? 'text-white bg-retail-green/10 border border-retail-green/25' : 'text-gray-300 hover:text-white hover:bg-retail-green/10' }} transition-colors">
                                <i class="fas fa-calendar-check {{ Route::currentRouteName()==='admin.hr.schedules' ? 'text-retail-green' : 'text-gray-400' }}"></i>
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
                    <h1 class="text-2xl font-bold text-white">Lịch làm việc</h1>
                    <button id="openCreateModal" class="px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Thêm lịch
                    </button>
                </div>

                <!-- Bộ lọc đơn giản -->
                <form id="scheduleFilter" method="GET" action="{{ route('admin.hr.schedules') }}" class="bg-dark-surface rounded-lg p-4 mb-6 border border-dark-border">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Xem theo</label>
                            <select name="view" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent">
                                <option value="week" {{ request('view','week')==='week' ? 'selected' : '' }}>Tuần này</option>
                                <option value="month" {{ request('view')==='month' ? 'selected' : '' }}>Tháng này</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Ngày bắt đầu</label>
                            <input name="start" type="date" value="{{ request('start') }}" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Bộ phận</label>
                            <select name="department" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent">
                                <option value="">Tất cả</option>
                                <option value="Rạp phim" {{ request('department')==='Rạp phim'?'selected':'' }}>Rạp phim</option>
                                <option value="Bán vé" {{ request('department')==='Bán vé'?'selected':'' }}>Bán vé</option>
                                <option value="Quầy bắp nước" {{ request('department')==='Quầy bắp nước'?'selected':'' }}>Quầy bắp nước</option>
                                <option value="Vệ sinh" {{ request('department')==='Vệ sinh'?'selected':'' }}>Vệ sinh</option>
                            </select>
                        </div>
                        <div class="flex items-end gap-2">
                            <input type="hidden" name="applied" value="{{ request('applied') }}">
                            <button id="applyBtn" type="submit" class="w-full px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg transition-colors">Áp dụng</button>
                            <button id="resetBtn" type="reset" class="w-full px-4 py-2 border border-dark-border rounded-lg hover:bg-white/5 text-center">Xóa</button>
                        </div>
                    </div>
                </form>

                <!-- Lịch làm việc dạng bảng -->
                <div class="overflow-x-auto bg-dark-surface rounded-lg border border-dark-border">
                    <table class="min-w-full divide-y divide-dark-border">
                        <thead class="bg-white/5">
                            <tr>
                                @foreach(($dates ?? []) as $d)
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        {{ ['Chủ nhật','Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7'][$d->dayOfWeek] }}<br>
                                        <span class="text-gray-500 normal-case">{{ $d->format('d/m') }}</span>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dark-border">
                            <tr>
                                @foreach(($dates ?? []) as $d)
                                    <td class="align-top px-4 py-3 space-y-2">
                                        @forelse(($grouped[$d->toDateString()] ?? []) as $item)
                                            <div class="p-3 rounded-lg border border-dark-border bg-white/5">
                                                <div class="text-sm font-semibold text-white">{{ $item->employee->name ?? 'NV' }}</div>
                                                <div class="text-xs text-gray-300">{{ substr($item->start_time,0,5) }} - {{ substr($item->end_time,0,5) }}</div>
                                                <div class="text-xs text-gray-400">{{ $item->location ?? $item->department ?? '—' }}</div>
                                            </div>
                                        @empty
                                            <div class="text-xs text-gray-500">Không có lịch</div>
                                        @endforelse
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Modal tạo lịch -->
                <div id="createModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
                    <div class="absolute inset-0 bg-black/50"></div>
                    <div class="relative bg-dark-surface border border-dark-border rounded-lg w-full max-w-lg p-6 z-10">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Thêm lịch làm việc</h3>
                            <button id="closeCreateModal" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
                        </div>
                        <form method="POST" action="{{ route('admin.hr.schedules.store') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm mb-1">Nhân viên</label>
                                <select name="employee_id" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white" required>
                                    <option value="">-- Chọn --</option>
                                    @foreach(($employees ?? []) as $emp)
                                        <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->department }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm mb-1">Ngày</label>
                                    <input type="date" name="date" value="{{ $start ?? now()->toDateString() }}" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white" required>
                                </div>
                                <div>
                                    <label class="block text-sm mb-1">Bộ phận</label>
                                    <select name="department" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white">
                                        <option value="">Tự động theo NV</option>
                                        @foreach(($departments ?? []) as $dep)
                                            <option value="{{ $dep }}">{{ $dep }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-sm mb-1">Bắt đầu</label>
                                    <input type="time" name="start_time" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white" required>
                                </div>
                                <div>
                                    <label class="block text-sm mb-1">Kết thúc</label>
                                    <input type="time" name="end_time" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white" required>
                                </div>
                                <div>
                                    <label class="block text-sm mb-1">Ca</label>
                                    <select name="shift" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white">
                                        <option value="Sáng">Sáng</option>
                                        <option value="Chiều">Chiều</option>
                                        <option value="Tối">Tối</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm mb-1">Vị trí</label>
                                    <input type="text" name="location" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white" placeholder="Rạp 1 / Quầy bắp nước...">
                                </div>
                                <div>
                                    <label class="block text-sm mb-1">Ghi chú</label>
                                    <input type="text" name="notes" class="block w-full py-2 px-3 border border-dark-border rounded-lg bg-dark-surface text-white" placeholder="Ghi chú (nếu có)">
                                </div>
                            </div>
                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" id="cancelCreateModal" class="px-4 py-2 border border-dark-border rounded-lg">Hủy</button>
                                <button type="submit" class="px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        setTimeout(function(){ var m=document.getElementById('success-message'); if(m){ m.style.opacity='0'; setTimeout(function(){ m.remove(); }, 300); } }, 3000);
        (function(){
            var form = document.getElementById('scheduleFilter');
            var apply = document.getElementById('applyBtn');
            var reset = document.getElementById('resetBtn');
            form.addEventListener('submit', function(){
                if (!form.querySelector('input[name="applied"]')) {
                    var h = document.createElement('input');
                    h.type = 'hidden'; h.name = 'applied'; h.value = '1';
                    form.appendChild(h);
                } else {
                    form.querySelector('input[name="applied"]').value = '1';
                }
            });
            form.addEventListener('reset', function(e){
                e.preventDefault();
                window.location.href = '{{ route('admin.hr.schedules') }}?reset=1';
            });

            var modal = document.getElementById('createModal');
            var openBtn = document.getElementById('openCreateModal');
            var closeBtn = document.getElementById('closeCreateModal');
            var cancelBtn = document.getElementById('cancelCreateModal');
            function open(){ modal.classList.remove('hidden'); }
            function close(){ modal.classList.add('hidden'); }
            if (openBtn) openBtn.addEventListener('click', open);
            if (closeBtn) closeBtn.addEventListener('click', close);
            if (cancelBtn) cancelBtn.addEventListener('click', close);
        })();
    </script>
</body>
</html>
