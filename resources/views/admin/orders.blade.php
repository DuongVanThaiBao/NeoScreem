<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý Đơn hàng / Suất chiếu - NeoScreem</title>
    <link href="/favicon.svg" rel="icon" type="image/svg+xml" onerror="this.href='/favicon.ico'"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-dark-bg { background-color: #1f2937; }
        .glass-morphism { background: rgba(26,26,26,0.8); backdrop-filter: blur(10px); border: 1px solid rgba(79,195,247,0.15); }
        .layout { display: flex; min-height: 100vh; }
        .main-content { flex: 1; position: relative; min-height: 100vh; }
        .header { position: relative; z-index: 100; }
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
                        <i class="fas fa-ticket-alt text-dark-bg text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Quản lý Đơn hàng / Suất chiếu</span>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-lg mx-8 relative">
                    <div class="relative z-10">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <form method="GET" action="{{ route('admin.orders.index') }}" class="block" id="orderSearchForm">
                            <input type="text"
                                   name="q"
                                   id="order_q"
                                   class="block w-full pl-10 pr-3 py-2 border border-dark-border rounded-lg bg-dark-surface text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-retail-green focus:border-transparent"
                                   placeholder="Tìm mã đơn, tên khách, phim..."
                                   value="{{ request('q') }}">
                        </form>
                        <!-- Autocomplete dropdown -->
                        <div id="orderSearchSuggestions" class="fixed mt-1 left-0 right-0 bg-dark-surface border border-dark-border rounded-lg shadow-lg z-[9999] hidden" style="width: var(--search-width); top: var(--search-top); left: var(--search-left);">
                            <ul id="orderSearchSuggestionList" class="max-h-72 overflow-auto divide-y divide-dark-border"></ul>
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
                            <a href="{{ route('admin.orders.index') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25">
                                <i class="fas fa-ticket-alt text-retail-green"></i>
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
            <!-- Orders list -->
            <div class="chart-container">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                    <h3 class="text-lg font-semibold text-white">Danh sách đơn hàng</h3>
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-wrap items-center gap-2">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Mã đơn / Tên khách / Email" class="px-3 py-1 bg-dark-surface border border-dark-border rounded text-white text-sm">
                        <select name="movie_id" class="px-3 py-1 bg-dark-surface border border-dark-border rounded text-white text-sm">
                            <option value="">Tất cả phim</option>
                            @if(isset($movies))
                                @foreach($movies as $m)
                                    <option value="{{ $m->id }}" @selected(request('movie_id')==$m->id)>{{ $m->title ?? ('#'.$m->id) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <select name="status" class="px-3 py-1 bg-dark-surface border border-dark-border rounded text-white text-sm">
                            <option value="">Tất cả trạng thái</option>
                            <option value="paid" @selected(request('status')==='paid')>Đã thanh toán</option>
                            <option value="canceled" @selected(request('status')==='canceled')>Hủy</option>
                            <option value="pending" @selected(request('status')==='pending')>Chờ xử lý</option>
                        </select>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3 py-1 bg-dark-surface border border-dark-border rounded text-white text-sm">
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-1 bg-dark-surface border border-dark-border rounded text-white text-sm">
                        <button class="px-3 py-1 bg-retail-green/20 border border-retail-green/40 rounded text-white text-sm">Lọc</button>
                    </form>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left border-b border-dark-border">
                                <th class="px-3 py-2 text-gray-400 text-xs">Mã đơn</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Khách hàng</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Phim</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Suất chiếu</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Số vé</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Tổng tiền</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Trạng thái</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Ngày đặt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($orders) && $orders instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                                @forelse($orders as $o)
                                    <tr class="border-b border-dark-border/60 hover:bg-white/5">
                                        <td class="px-3 py-2">{{ $o->code ?? ('#'.$o->id) }}</td>
                                        <td class="px-3 py-2">{{ $o->customer_name ?? '—' }}</td>
                                        <td class="px-3 py-2">{{ optional($o->movie)->title ?? ($o->movie_title ?? '—') }}</td>
                                        <td class="px-3 py-2">{{ optional($o->screening)->screening_time ? \Carbon\Carbon::parse($o->screening->screening_time)->format('H:i d/m/Y') : (isset($o->screening_time) ? \Carbon\Carbon::parse($o->screening_time)->format('H:i d/m/Y') : '—') }}</td>
                                        <td class="px-3 py-2">{{ $o->tickets_count ?? '—' }}</td>
                                        <td class="px-3 py-2">{{ isset($o->total_amount) ? ('₫'.number_format($o->total_amount,0,',','.')) : '—' }}</td>
                                        <td class="px-3 py-2">{{ $o->status ?? '—' }}</td>
                                        <td class="px-3 py-2">{{ optional($o->created_at)->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="px-3 py-6 text-center text-gray-400">Không có đơn hàng</td></tr>
                                @endforelse
                            @else
                                <tr><td colspan="8" class="px-3 py-6 text-center text-yellow-400">Chưa có model/tables cho đơn hàng. Vui lòng tạo schema để hiển thị dữ liệu thật.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">@if(isset($orders) && $orders instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {{ $orders->links() }} @endif</div>
            </div>

            <!-- Screenings management -->
            <div class="chart-container">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Quản lý Suất chiếu</h3>
                    <div class="text-sm text-gray-400">(Cần models/schemas để thao tác thêm/sửa/xóa)</div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="text-left border-b border-dark-border">
                                <th class="px-3 py-2 text-gray-400 text-xs">Phim</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Phòng chiếu</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Thời gian</th>
                                <th class="px-3 py-2 text-gray-400 text-xs">Giá vé</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(($screenings ?? []) as $s)
                                <tr class="border-b border-dark-border/60 hover:bg-white/5">
                                    <td class="px-3 py-2">{{ optional($s->movie)->title ?? ('#'.$s->movie_id) }}</td>
                                    <td class="px-3 py-2">{{ $s->room_name ?? '—' }}</td>
                                    <td class="px-3 py-2">{{ isset($s->screening_time) ? \Carbon\Carbon::parse($s->screening_time)->format('H:i d/m/Y') : '—' }}</td>
                                    <td class="px-3 py-2">{{ isset($s->price) ? ('₫'.number_format($s->price,0,',','.')) : '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-3 py-6 text-center text-gray-400">Chưa có suất chiếu</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Statistics -->
            <div class="chart-container">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Thống kê</h3>
                    <div class="text-sm text-gray-400">Doanh thu theo ngày/tháng, vé bán theo phim/suất (kết nối số liệu thật sau)</div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <canvas id="ordersRevenueChart" height="160"></canvas>
                    </div>
                    <div>
                        <canvas id="ticketsByMovieChart" height="160"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>
<script>
(function(){
  const form = document.getElementById('orderSearchForm'); if(!form) return;
  const input = document.getElementById('order_q');
  const box = document.getElementById('orderSearchSuggestions');
  const list = document.getElementById('orderSearchSuggestionList');
  let items=[], activeIndex=-1, timer;
  function updatePosition(){
    const r = input.getBoundingClientRect();
    document.documentElement.style.setProperty('--search-width', r.width + 'px');
    document.documentElement.style.setProperty('--search-top', (r.bottom + window.scrollY) + 'px');
    document.documentElement.style.setProperty('--search-left', (r.left + window.scrollX) + 'px');
  }
  function showBox(){ updatePosition(); box.classList.remove('hidden'); }
  function hideBox(){ box.classList.add('hidden'); activeIndex=-1; }
  function clearList(){ list.innerHTML=''; items=[]; activeIndex=-1; }
  function sidebarEntries(){ const arr=[]; document.querySelectorAll('aside.sidebar a').forEach(a=>{ const label=(a.textContent||'').trim(); const href=a.getAttribute('href')||'#'; if(label) arr.push({type:'nav', label, href});}); return arr; }
  function buildSuggestions(q){ const query=q.trim(); if(!query) return []; const ql=query.toLowerCase(); const nav=sidebarEntries().filter(x=>x.label.toLowerCase().includes(ql)).slice(0,5); const ents=[{type:'entity', entity:'order', label:`Tìm đơn hàng: \"${query}\"`, payload:`order:${query}`}]; return [...ents, ...nav]; }
  function render(data){ clearList(); items=data; if(items.length===0){ hideBox(); return;} const frag=document.createDocumentFragment(); items.forEach((it,idx)=>{ const li=document.createElement('li'); li.className='px-3 py-2 hover:bg-white/5 cursor-pointer flex items-center justify-between'; const span=document.createElement('span'); span.textContent=it.label; const meta=document.createElement('span'); meta.className='text-xs text-gray-400'; meta.textContent= it.type==='nav'?'Điều hướng':'Đơn hàng'; li.appendChild(span); li.appendChild(meta); li.addEventListener('mousedown', e=>{ e.preventDefault(); select(idx);}); frag.appendChild(li);}); list.appendChild(frag); showBox(); }
  function highlight(){ Array.from(list.children).forEach((el,i)=>{ if(i===activeIndex) el.classList.add('bg-white/10'); else el.classList.remove('bg-white/10');}); }
  function select(i){ const it=items[i]; if(!it) return; if(it.type==='nav' && it.href && it.href!=='#'){ window.location.href=it.href; return;} input.value=it.payload; form.submit(); }
  input.addEventListener('input', function(){ clearTimeout(timer); const q=this.value; timer=setTimeout(()=>{ render(buildSuggestions(q)); }, 120); });
  input.addEventListener('keydown', function(e){ if(box.classList.contains('hidden')) return; const max=items.length-1; if(e.key==='ArrowDown'){ e.preventDefault(); activeIndex=Math.min(max,activeIndex+1); highlight(); } else if(e.key==='ArrowUp'){ e.preventDefault(); activeIndex=Math.max(0,activeIndex-1); highlight(); } else if(e.key==='Enter'){ if(activeIndex>=0){ e.preventDefault(); select(activeIndex);} } else if(e.key==='Escape'){ hideBox(); }});
  document.addEventListener('click', function(e){ if(!box.contains(e.target) && e.target!==input) hideBox(); });
  window.addEventListener('resize', updatePosition);
  window.addEventListener('scroll', updatePosition, true);
  form.addEventListener('submit', function(e){ const q=(input.value||'').trim().toLowerCase(); if(!q) return; const links=document.querySelectorAll('aside.sidebar a'); for(const a of links){ const label=(a.textContent||'').trim().toLowerCase(); const href=a.getAttribute('href')||'#'; if(label.includes(q) && href!=='#'){ e.preventDefault(); window.location.href=href; return; } } });
})();
</script>
</body>
</html>
