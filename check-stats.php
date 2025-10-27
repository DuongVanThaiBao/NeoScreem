<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING CURRENT STATISTICS ===\n";

$today = now()->toDateString();
$stats = \App\Models\Statistics::where('date', $today)->first();

if ($stats) {
    echo "Found statistics for today ({$today}):\n";
    echo "Tickets: {$stats->tickets_sold_today}\n";
    echo "Revenue: {$stats->revenue_today}\n";
    echo "Avg Customers: {$stats->avg_customers_per_store}\n";
    echo "ROI: {$stats->campaign_roi}\n";
} else {
    echo "No statistics found for today. Creating new record...\n";

    \App\Models\Statistics::create([
        'tickets_sold_today' => 0,
        'revenue_today' => 0,
        'avg_customers_per_store' => 0,
        'campaign_roi' => 0,
        'conversion_rate_by_hour' => [
            '9h' => 0, '10h' => 0, '11h' => 0, '12h' => 0,
            '13h' => 0, '14h' => 0
        ],
        'store_heatmap_data' => [
            'screen_area' => ['xanh_duong' => 100, 'do' => 0],
            'seating_area' => ['xanh_duong' => 100, 'do' => 0],
            'concession_area' => ['vang' => 100, 'xanh_la' => 0]
        ],
        'marketing_campaign_stats' => [
            'clicks' => 0,
            'interactions' => 0,
            'revenue' => 0,
            'roi' => 0
        ],
        'date' => $today
    ]);

    echo "Created new statistics record with zero values.\n";
}

echo "\n=== DASHBOARD WILL SHOW ===\n";
echo "Tickets: 0\n";
echo "Revenue: ₫0\n";
echo "Avg Customers: 0\n";
echo "ROI: 0%\n";
echo "Conversion: All 0%\n";
echo "Heatmap: All blue (no activity)\n";

echo "\n=== TO ADD REAL DATA ===\n";
echo "Visit: /test-update-stats (adds sample sales data)\n";
echo "Or manually trigger: StatisticsHelper::recordTicketPurchase(price, storeId)\n";
?>
