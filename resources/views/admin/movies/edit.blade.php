<!DOCTYPE html>
<html lang="vi" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa phim - NeoScreem</title>
    <link href="/favicon.svg" rel="icon" type="image/svg+xml" onerror="this.href='/favicon.ico'"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-dark-bg { background-color: #1f2937; }
        .glass-morphism { background: rgba(26,26,26,0.8); backdrop-filter: blur(10px); border: 1px solid rgba(79,195,247,0.15); }
        .layout { display: flex; min-height: 100vh; }
        .main-content { flex: 1; position: relative; z-index: 20; min-height: 100vh; }
        .sidebar { width: 250px; background: inherit; height: 100vh; position: sticky; top: 0; z-index: 10; overflow-y: auto; }
        .card { background: rgba(26,26,26,0.8); backdrop-filter: blur(10px); border: 1px solid rgba(79,195,247,0.15); border-radius: .5rem; padding: 1.25rem; }
        label { color: #9ca3af; font-size: .875rem; }
        input[type="text"], input[type="number"], input[type="date"], textarea, select { background:#111827; border-color:#374151; color:#fff; }
    </style>
</head>
<body class="bg-dark-bg text-white font-sans">
<header class="glass-morphism border-b border-dark-border header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-retail-green rounded-lg flex items-center justify-center">
                    <i class="fas fa-film text-dark-bg text-lg"></i>
                </div>
                <span class="text-xl font-bold text-white">Chỉnh sửa phim</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.movies') }}" class="text-sm text-gray-300 hover:text-white"><i class="fas fa-arrow-left mr-2"></i>Danh sách phim</a>
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
                    <li><a href="{{ route('admin.admin') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-home text-gray-400"></i><span>Trang chủ</span></a></li>
                    <li><a href="{{ route('admin.dashboard.stats') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-tachometer-alt text-gray-400"></i><span>RetailPulse Dashboard</span></a></li>
                </ul>
            </div>
            <div class="mb-6">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Quản lý</h3>
                <ul class="space-y-2">
                    <li><a href="/admin/stores" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-store text-gray-400"></i><span>Quản lý cửa hàng</span></a></li>
                    <li><a href="{{ route('admin.movies') }}" class="sidebar-item active flex items-center space-x-3 px-4 py-3 rounded-lg text-white bg-retail-green/10 border border-retail-green/25"><i class="fas fa-film text-retail-green"></i><span>Quản lý phim</span></a></li>
                    <li><a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-users text-gray-400"></i><span>Quản lý người dùng</span></a></li>
                    <li><a href="{{ route('admin.orders.index') }}" class="sidebar-item flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:text-white hover:bg-retail-green/10 transition-colors"><i class="fas fa-ticket-alt text-gray-400"></i><span>Đơn hàng / Suất chiếu</span></a></li>
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

    <main class="main-content p-6 space-y-6">
        <div class="card">
            <h3 class="text-lg font-semibold text-white mb-4">Cập nhật thông tin phim</h3>
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-300">@foreach ($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>
            @endif
            <form method="POST" action="{{ route('admin.movies.update', $movie['id']) }}" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="title">Tên phim</label>
                        <input type="text" id="title" name="title" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('title', $movie['title'] ?? '') }}" required>
                    </div>
                    <div>
                        <label for="genre">Thể loại</label>
                        <input type="text" id="genre" name="genre" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('genre', $movie['genre'] ?? '') }}" required>
                    </div>
                    <div>
                        <label for="director">Đạo diễn</label>
                        <input type="text" id="director" name="director" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('director', $movie['director'] ?? '') }}" required>
                    </div>
                    <div>
                        <label for="cast">Diễn viên</label>
                        <input type="text" id="cast" name="cast" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('cast', $movie['cast'] ?? '') }}" required>
                    </div>
                    <div>
                        <label for="duration">Thời lượng (phút)</label>
                        <input type="number" id="duration" name="duration" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('duration', $movie['duration'] ?? '') }}" min="1" required>
                    </div>
                    <div>
                        <label for="release_date">Ngày phát hành</label>
                        <input type="date" id="release_date" name="release_date" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('release_date', $movie['release_date'] ?? '') }}" required>
                    </div>
                    <div>
                        <label for="status">Trạng thái</label>
                        <select id="status" name="status" class="w-full mt-1 px-3 py-2 border rounded" required>
                            @php($st = old('status', $movie['status'] ?? ''))
                            <option value="đang chiếu" {{ $st==='đang chiếu' ? 'selected' : '' }}>Đang chiếu</option>
                            <option value="sắp chiếu" {{ $st==='sắp chiếu' ? 'selected' : '' }}>Sắp chiếu</option>
                            <option value="đã kết thúc" {{ $st==='đã kết thúc' ? 'selected' : '' }}>Đã kết thúc</option>
                        </select>
                    </div>
                    <div>
                        <label for="language">Ngôn ngữ</label>
                        <input type="text" id="language" name="language" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('language', $movie['language'] ?? '') }}" required>
                    </div>
                    <div>
                        <label for="country">Quốc gia</label>
                        <input type="text" id="country" name="country" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('country', $movie['country'] ?? '') }}" required>
                    </div>
                    <div class="md:col-span-2">
                        <label for="description">Mô tả</label>
                        <textarea id="description" name="description" rows="4" class="w-full mt-1 px-3 py-2 border rounded" required>{{ old('description', $movie['description'] ?? '') }}</textarea>
                    </div>
                    <div>
                        <label for="poster">Poster (URL)</label>
                        <input type="text" id="poster" name="poster" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('poster', $movie['poster'] ?? '') }}">
                    </div>
                    <div>
                        <label for="trailer">Trailer (URL)</label>
                        <input type="text" id="trailer" name="trailer" class="w-full mt-1 px-3 py-2 border rounded" value="{{ old('trailer', $movie['trailer'] ?? '') }}">
                    </div>
                </div>
                <div class="pt-2">
                    <button type="submit" class="px-4 py-2 bg-retail-green hover:bg-retail-green/80 text-dark-bg font-semibold rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i> Cập nhật phim
                    </button>
                    <a href="{{ route('admin.movies') }}" class="ml-3 px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg">Hủy</a>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>
