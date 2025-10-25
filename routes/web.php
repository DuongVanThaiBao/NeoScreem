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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

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