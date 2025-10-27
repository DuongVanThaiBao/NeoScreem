<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Statistics;

class StatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create empty record for today, no sample data
        Statistics::firstOrCreate(
            ['date' => now()->toDateString()],
            [
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
                ]
            ]
        );
    }
}
