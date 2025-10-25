<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistics extends Model
{
    protected $fillable = [
        'tickets_sold_today',
        'revenue_today',
        'avg_customers_per_store',
        'campaign_roi',
        'conversion_rate_by_hour',
        'store_heatmap_data',
        'marketing_campaign_stats',
        'date'
    ];

    protected $casts = [
        'conversion_rate_by_hour' => 'array',
        'store_heatmap_data' => 'array',
        'marketing_campaign_stats' => 'array',
        'date' => 'date'
    ];

    /**
     * Get today's statistics or create if not exists
     */
    public static function getTodayStats()
    {
        return static::firstOrCreate(
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

    /**
     * Get formatted revenue with currency
     */
    public function getFormattedRevenueAttribute()
    {
        return '₫' . number_format($this->revenue_today, 0, ',', '.');
    }

    /**
     * Get formatted ROI with percentage
     */
    public function getFormattedRoiAttribute()
    {
        return $this->campaign_roi . '%';
    }
}
