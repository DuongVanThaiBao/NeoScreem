<?php

use App\Http\Controllers\Auth\{
    LoginController,
    RegisterMsController,
    PasswordResetLinkController,
    NewPasswordController,
    VerificationController
};
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\EmployeeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;

// Verification routes
Route::get('/verify', [VerificationController::class, 'showVerificationForm'])->name('verify.form');
Route::post('/verify', [VerificationController::class, 'verify'])->name('verify.check');
Route::get('/send-code/{email}', [VerificationController::class, 'sendVerificationCode'])->name('verify.send');

// Block onboarding.js
Route::get('/onboarding.js', function () {
    abort(404, 'Onboarding script not found. This appears to be blocked by the ULTIMATE ONBOARDING KILLER protection system.');
})->name('onboarding.blocked');

// Register / Login routes
Route::get('/register', [RegisterMsController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterMsController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forgot / Reset Password (nằm ngoài auth middleware)
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

// Routes yêu cầu đăng nhập
Route::middleware(['auth'])->group(function () {

    Route::get('/admin', [StatisticsController::class, 'adminHome'])->name('admin.admin');
    Route::get('/admin/dashboard', [StatisticsController::class, 'dashboard'])->name('admin.dashboard.stats');
    Route::get('/admin/users', [\App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{id}/edit', [\App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [\App\Http\Controllers\Admin\UsersController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/orders', [\App\Http\Controllers\Admin\OrdersController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/marketing/campaigns', [\App\Http\Controllers\Admin\MarketingController::class, 'campaigns'])->name('admin.marketing.campaigns');
    Route::get('/admin/marketing/analytics', [\App\Http\Controllers\Admin\MarketingController::class, 'analytics'])->name('admin.marketing.analytics');
    Route::get('/admin/marketing/targets', [\App\Http\Controllers\Admin\MarketingController::class, 'targets'])->name('admin.marketing.targets');
    Route::post('/admin/marketing/targets/segments', [\App\Http\Controllers\Admin\MarketingController::class, 'storeSegment'])->name('admin.marketing.targets.segments.store');
    Route::get('/admin/marketing/targets/segments/export', [\App\Http\Controllers\Admin\MarketingController::class, 'exportSegment'])->name('admin.marketing.targets.segments.export');
    
    // Store management routes
    Route::get('/admin/stores', [StoreController::class, 'index'])->name('admin.stores');
    Route::put('/admin/stores', [StoreController::class, 'update'])->name('admin.stores.update');
    
    // Movie management routes
    Route::get('/admin/movies', [MovieController::class, 'index'])->name('admin.movies');
    Route::get('/admin/movies/create', [MovieController::class, 'create'])->name('admin.movies.create');
    Route::post('/admin/movies', [MovieController::class, 'store'])->name('admin.movies.store');
    Route::get('/admin/movies/{id}/edit', [MovieController::class, 'edit'])->name('admin.movies.edit');
    Route::put('/admin/movies/{id}', [MovieController::class, 'update'])->name('admin.movies.update');
    Route::delete('/admin/movies/{id}', [MovieController::class, 'destroy'])->name('admin.movies.destroy');
    Route::get('/admin/movies/statistics', [MovieController::class, 'statistics'])->name('admin.movies.statistics');

    Route::prefix('admin/api')->group(function () {
        Route::get('/statistics', [StatisticsController::class, 'refresh'])->name('api.statistics');
        Route::post('/statistics/update', [StatisticsController::class, 'update']);
        Route::get('/statistics/date', [StatisticsController::class, 'getByDate']);
    });

    // HR Employees routes
    Route::prefix('admin/hr')->name('admin.hr.')->group(function(){
        Route::get('/schedules', [\App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('schedules');
        Route::post('/schedules', [\App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('schedules.store');
        Route::get('/reports', [\App\Http\Controllers\Admin\HrReportsController::class, 'index'])->name('reports');
        Route::get('/reports/export/csv', [\App\Http\Controllers\Admin\HrReportsController::class, 'exportCsv'])->name('reports.export.csv');
        Route::get('/reports/export/print', [\App\Http\Controllers\Admin\HrReportsController::class, 'exportPrint'])->name('reports.export.print');
        Route::post('/reports/schedule', [\App\Http\Controllers\Admin\HrReportsController::class, 'storeSchedule'])->name('reports.schedule');
        Route::post('/reports/template', [\App\Http\Controllers\Admin\HrReportsController::class, 'storeTemplate'])->name('reports.template');
        Route::resource('employees', EmployeeController::class);
    });

    // System settings (closure-based)
    Route::get('/admin/system/settings', function(){
        $path = storage_path('app/settings.json');
        $settings = [];
        if (file_exists($path)) {
            try { $settings = json_decode(file_get_contents($path), true) ?: []; } catch (\Throwable $e) { $settings = []; }
        }
        return view('admin.system.settings', compact('settings'));
    })->name('admin.system.settings');

    Route::put('/admin/system/settings', function(Request $request){
        $validated = $request->validate([
            'cinema_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'work_hours' => 'required|array',
            'work_hours.*.open' => 'required|date_format:H:i',
            'work_hours.*.close' => 'required|date_format:H:i',
            'ticket_prices' => 'required|array',
            'ticket_prices.standard' => 'required|numeric|min:0',
            'ticket_prices.3d' => 'required|numeric|min:0',
            'ticket_prices.imax' => 'required|numeric|min:0',
        ]);

        $settings = [
            'cinema_name' => $validated['cinema_name'],
            'phone' => $validated['phone'] ?? '',
            'address' => $validated['address'] ?? '',
            'work_hours' => array_map(function($day){
                return [
                    'open' => $day['open'] ?? '08:00',
                    'close' => $day['close'] ?? '22:00',
                    'is_holiday' => isset($day['is_holiday']) && (bool)$day['is_holiday'],
                ];
            }, $validated['work_hours']),
            'ticket_prices' => $validated['ticket_prices'],
            'maintenance_mode' => (bool)$request->boolean('maintenance_mode'),
            'allow_online_booking' => (bool)$request->boolean('allow_online_booking', true),
            'enable_email_notifications' => (bool)$request->boolean('enable_email_notifications', true),
            'updated_at' => now()->toDateTimeString(),
        ];

        $path = storage_path('app/settings.json');
        try { file_put_contents($path, json_encode($settings, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)); } catch (\Throwable $e) {}

        return redirect()->route('admin.system.settings')->with('success', 'Đã lưu cài đặt hệ thống');
    })->name('admin.system.settings.update');

    // System security (closure-based)
    Route::get('/admin/system/security', function(){
        $path = storage_path('app/security.json');
        $security = [];
        if (file_exists($path)) {
            try { $security = json_decode(file_get_contents($path), true) ?: []; } catch (\Throwable $e) { $security = []; }
        }
        return view('admin.system.security', compact('security'));
    })->name('admin.system.security');

    Route::put('/admin/system/security', function(Request $request){
        $validated = $request->validate([
            'password_policy' => 'required|array',
            'password_policy.min_length' => 'required|integer|min:6|max:128',
            'password_policy.require_uppercase' => 'sometimes|boolean',
            'password_policy.require_number' => 'sometimes|boolean',
            'two_factor_enabled' => 'sometimes|boolean',
            'session_timeout' => 'required|integer|min:5|max:1440',
            'login_attempts_limit' => 'required|integer|min:1|max:10',
            'ip_whitelist' => 'nullable|string',
        ]);

        $security = [
            'password_policy' => [
                'min_length' => (int)($validated['password_policy']['min_length'] ?? 8),
                'require_uppercase' => (bool)$request->boolean('password_policy.require_uppercase', true),
                'require_number' => (bool)$request->boolean('password_policy.require_number', true),
            ],
            'two_factor_enabled' => (bool)$request->boolean('two_factor_enabled', false),
            'session_timeout' => (int)($validated['session_timeout'] ?? 30),
            'login_attempts_limit' => (int)($validated['login_attempts_limit'] ?? 5),
            'ip_whitelist' => collect(preg_split("/\r?\n/", trim($validated['ip_whitelist'] ?? '')))
                                ->filter(fn($v)=>trim($v)!=='')
                                ->values()->all(),
            'updated_at' => now()->toDateTimeString(),
        ];

        $path = storage_path('app/security.json');
        try { file_put_contents($path, json_encode($security, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)); } catch (\Throwable $e) {}

        return redirect()->route('admin.system.security')->with('success', 'Đã lưu cài đặt bảo mật');
    })->name('admin.system.security.update');

    // System backup
    Route::get('/admin/system/backup', function(){
        $dir = storage_path('app/backups');
        if (!is_dir($dir)) @mkdir($dir, 0775, true);
        $files = collect(glob($dir.DIRECTORY_SEPARATOR.'*.zip'))
            ->map(function($p){ return [
                'name' => basename($p),
                'size' => number_format(filesize($p)/1024/1024, 2).' MB',
                'modified' => date('Y-m-d H:i:s', filemtime($p)),
                'path' => $p,
            ]; })
            ->sortByDesc('modified')->values()->all();
        $backups = $files;
        return view('admin.system.backup', compact('backups'));
    })->name('admin.system.backup');

    Route::post('/admin/system/backup/create', function(){
        $dir = storage_path('app/backups');
        if (!is_dir($dir)) @mkdir($dir, 0775, true);
        $name = 'backup_'.date('Ymd_His').'.zip';
        $zipPath = $dir.DIRECTORY_SEPARATOR.$name;
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
            // Include app JSON configs as demo data
            foreach (['settings.json','security.json'] as $f) {
                $p = storage_path('app'.DIRECTORY_SEPARATOR.$f);
                if (file_exists($p)) $zip->addFile($p, $f);
            }
            // Include .env if exists (optional, comment out if undesired)
            $env = base_path('.env'); if (file_exists($env)) { $zip->addFile($env, 'env.sample'); }
            $zip->close();
        }
        return redirect()->route('admin.system.backup')->with('success', 'Đã tạo bản sao lưu: '.$name);
    })->name('admin.system.backup.create');

    Route::get('/admin/system/backup/download', function(Request $request){
        $file = $request->query('file');
        $path = storage_path('app/backups'.DIRECTORY_SEPARATOR.$file);
        abort_unless($file && file_exists($path), 404);
        return response()->download($path, $file);
    })->name('admin.system.backup.download');

    Route::post('/admin/system/backup/delete', function(Request $request){
        $file = $request->query('file');
        $path = storage_path('app/backups'.DIRECTORY_SEPARATOR.$file);
        if ($file && file_exists($path)) @unlink($path);
        return redirect()->route('admin.system.backup')->with('success', 'Đã xóa bản sao lưu');
    })->name('admin.system.backup.delete');

    // System logs
    Route::get('/admin/system/logs', function(){
        $logPath = storage_path('logs/laravel.log');
        if (!file_exists($logPath)) { @file_put_contents($logPath, ""); }
        $content = @file_get_contents($logPath) ?: '';
        $logContent = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
        return view('admin.system.logs', compact('logContent'));
    })->name('admin.system.logs');

    Route::post('/admin/system/logs/clear', function(){
        $logPath = storage_path('logs/laravel.log');
        @file_put_contents($logPath, "");
        return redirect()->route('admin.system.logs')->with('success', 'Đã xóa log');
    })->name('admin.system.logs.clear');

    Route::get('/admin/system/logs/download', function(){
        $logPath = storage_path('logs/laravel.log');
        if (!file_exists($logPath)) { @file_put_contents($logPath, ""); }
        return response()->download($logPath, 'laravel.log');
    })->name('admin.system.logs.download');

    // --- Test update stats ---
    Route::get('/test-update-stats', function () {
        $statsService = app(\App\Services\StatisticsService::class);
        $ticketPrices = [50000, 75000, 100000, 85000, 60000];

        foreach ($ticketPrices as $price) {
            event(new \App\Events\TicketPurchased($price, 1, 1));
        }

        for ($i = 0; $i < 50; $i++) {
            event(new \App\Events\MarketingInteraction('click', 1, 0, 1));
        }

        $conversionRevenues = [75000, 150000, 200000];
        foreach ($conversionRevenues as $revenue) {
            event(new \App\Events\MarketingInteraction('conversion', 1, $revenue, 1));
        }

        return response()->json([
            'message' => 'Real sales data added to dashboard',
            'tickets_added' => count($ticketPrices),
            'clicks_added' => 50,
            'conversions_added' => count($conversionRevenues),
        ]);
    });

    // --- Reset today's stats ---
    Route::get('/reset-stats', function () {
        $today = now()->toDateString();
        $stats = \App\Models\Statistics::where('date', $today)->first();

        if ($stats) {
            $stats->update([
                'tickets_sold_today' => 0,
                'revenue_today' => 0,
                'avg_customers_per_store' => 0,
                'campaign_roi' => 0,
                'conversion_rate_by_hour' => [
                    '9h' => 0, '10h' => 0, '11h' => 0, '12h' => 0,
                    '13h' => 0, '14h' => 0,
                ],
                'store_heatmap_data' => [
                    'screen_area' => ['xanh_duong' => 100, 'do' => 0],
                    'seating_area' => ['xanh_duong' => 100, 'do' => 0],
                    'concession_area' => ['vang' => 100, 'xanh_la' => 0],
                ],
                'marketing_campaign_stats' => [
                    'clicks' => 0,
                    'interactions' => 0,
                    'revenue' => 0,
                    'roi' => 0,
                ],
            ]);

            return response()->json(['message' => 'Statistics reset to zero']);
        }

        return response()->json(['message' => 'No statistics found for today']);
    });

    // --- Reset all stats ---
    Route::get('/reset-all-stats', function () {
        \App\Models\Statistics::truncate();
        \App\Models\Statistics::create([
            'tickets_sold_today' => 0,
            'revenue_today' => 0,
            'avg_customers_per_store' => 0,
            'campaign_roi' => 0,
            'conversion_rate_by_hour' => [
                '9h' => 0, '10h' => 0, '11h' => 0, '12h' => 0,
                '13h' => 0, '14h' => 0,
            ],
            'store_heatmap_data' => [
                'screen_area' => ['xanh_duong' => 100, 'do' => 0],
                'seating_area' => ['xanh_duong' => 100, 'do' => 0],
                'concession_area' => ['vang' => 100, 'xanh_la' => 0],
            ],
            'marketing_campaign_stats' => [
                'clicks' => 0,
                'interactions' => 0,
                'revenue' => 0,
                'roi' => 0,
            ],
            'date' => now()->toDateString(),
        ]);

        return response()->json(['message' => 'All statistics reset to zero completely']);
    });

    // --- Authenticated refresh route ---
    Route::get('/test-refresh', function () {
        try {
            $todayStats = \App\Models\Statistics::getTodayStats();

            return response()->json([
                'success' => true,
                'message' => 'Real dashboard data retrieved successfully',
                'data' => $todayStats,
                'timestamp' => now()->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get data: ' . $e->getMessage(),
            ], 500);
        }
    });

    // --- Public refresh route (no auth) ---
    Route::get('/test-refresh-public', function () {
        try {
            $todayStats = \App\Models\Statistics::getTodayStats();

            return response()->json([
                'success' => true,
                'message' => 'Real dashboard data retrieved successfully',
                'timestamp' => now()->toDateTimeString(),
                'data' => [
                    'tickets_sold_today' => $todayStats->tickets_sold_today,
                    'revenue_today' => $todayStats->revenue_today,
                    'avg_customers_per_store' => $todayStats->avg_customers_per_store,
                    'campaign_roi' => $todayStats->campaign_roi,
                    'date' => $todayStats->date,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get real data: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ], 500);
        }
    });
});

// --- Public routes (no auth required) ---