<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistics;
use App\Services\StatisticsService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    protected $statisticsService;

    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * Get current statistics for dashboard
     */
    public function index(): JsonResponse
    {
        $stats = $this->statisticsService->getCurrentStats();

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Update statistics when new transaction occurs
     */
    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'required|string|in:ticket_sale,marketing_click,marketing_conversion',
            'amount' => 'nullable|numeric',
            'store_id' => 'nullable|integer',
            'campaign_id' => 'nullable|integer'
        ]);

        $updated = $this->statisticsService->updateStatistics($validated);

        return response()->json([
            'success' => true,
            'message' => 'Statistics updated successfully',
            'data' => $updated
        ]);
    }

    /**
     * Recalculate and return current statistics
     */
    public function refresh(): JsonResponse
    {
        try {
            // Get today's stats (this will recalculate derived metrics)
            $stats = Statistics::getTodayStats();

            return response()->json([
                'success' => true,
                'message' => 'Dashboard data refreshed successfully',
                'data' => $stats,
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to refresh data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Dashboard view with real-time data
     */
    public function dashboard(Request $request)
    {
        // Default: today's stats
        $stats = Statistics::getTodayStats();

        $search = trim((string) $request->query('search', ''));
        $searchFrom = null;
        $searchTo = null;

        if ($search !== '') {
            // Match dd/mm/YYYY
            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $search, $m)) {
                $d = str_pad($m[1], 2, '0', STR_PAD_LEFT);
                $M = str_pad($m[2], 2, '0', STR_PAD_LEFT);
                $Y = $m[3];
                $date = Carbon::createFromFormat('Y-m-d', "$Y-$M-$d");
                if ($date) {
                    $searchFrom = $date->toDateString();
                    $searchTo = $date->toDateString();
                    // For a single day search, load that day's KPIs
                    $stats = Statistics::whereDate('date', $searchFrom)->first() ?? Statistics::getTodayStats();
                }
            }
            // Match mm/YYYY (month/year)
            else if (preg_match('/^(\d{1,2})\/(\d{4})$/', $search, $m)) {
                $M = str_pad($m[1], 2, '0', STR_PAD_LEFT);
                $Y = $m[2];
                $start = Carbon::createFromFormat('Y-m-d', "$Y-$M-01")->startOfDay();
                $end = (clone $start)->endOfMonth()->startOfDay();
                $searchFrom = $start->toDateString();
                $searchTo = $end->toDateString();
                // KPIs remain today's by design for month search
            }
        }

        return view('admin.dashboard', [
            'stats' => $stats,
            'searchFrom' => $searchFrom,
            'searchTo' => $searchTo,
        ]);
    }

    /**
     * Return revenue time-series for chart
     * Supports: range=today|7days|30days or custom from/to (YYYY-MM-DD)
     */
    public function getByDate(Request $request): JsonResponse
    {
        $range = $request->query('range');
        $from = $request->query('from');
        $to = $request->query('to');

        try {
            if ($range === 'today') {
                $today = Carbon::today();
                $stats = Statistics::whereDate('date', $today->toDateString())->first();

                // Business hours labels (example)
                $labels = ['09h','10h','11h','12h','13h','14h'];
                $data = array_fill(0, count($labels), 0);

                if ($stats) {
                    $distribution = $stats->conversion_rate_by_hour ?? [];
                    $totalWeight = array_sum($distribution) ?: 1;
                    $i = 0;
                    foreach ($labels as $label) {
                        $key = str_replace('h', '', $label).'h';
                        $weight = $distribution[$key] ?? 0;
                        $data[$i] = round(($weight / $totalWeight) * ($stats->revenue_today ?? 0));
                        $i++;
                    }
                }

                return response()->json([
                    'success' => true,
                    'labels' => $labels,
                    'data' => $data,
                ]);
            }

            // Range presets
            if (in_array($range, ['7days','30days'])) {
                $days = $range === '7days' ? 7 : 30;
                $end = Carbon::today();
                $start = (clone $end)->subDays($days - 1);
                return $this->buildDailySeriesResponse($start, $end);
            }

            // Custom range by from/to
            if ($from && $to) {
                $start = Carbon::parse($from)->startOfDay();
                $end = Carbon::parse($to)->startOfDay();
                if ($start->gt($end)) {
                    [$start, $end] = [$end, $start];
                }
                return $this->buildDailySeriesResponse($start, $end);
            }

            // Default: last 7 days
            $end = Carbon::today();
            $start = (clone $end)->subDays(6);
            return $this->buildDailySeriesResponse($start, $end);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get chart data: '.$e->getMessage(),
            ], 500);
        }
    }

    private function buildDailySeriesResponse(Carbon $start, Carbon $end): JsonResponse
    {
        $cursor = (clone $start);
        $labels = [];
        $data = [];

        while ($cursor->lte($end)) {
            $dateStr = $cursor->toDateString();
            $labels[] = $cursor->format('d/m');
            $stats = Statistics::whereDate('date', $dateStr)->first();
            $data[] = $stats ? (int) $stats->revenue_today : 0;
            $cursor->addDay();
        }

        return response()->json([
            'success' => true,
            'labels' => $labels,
            'data' => $data,
            'from' => $start->toDateString(),
            'to' => $end->toDateString(),
        ]);
    }

    /**
     * Admin home page with overview and navigation
     */
    public function adminHome()
    {
        // Kiểm tra quyền admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'BẠN KHÔNG CÓ QUYỀN TRUY CẬP TRANG NÀY.');
        }

        return view('admin.admin');
    }
}