<?php

namespace App\Listeners;

use App\Events\MarketingInteraction;
use App\Services\StatisticsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStatisticsOnMarketingInteraction implements ShouldQueue
{
    protected $statisticsService;

    /**
     * Create the event listener.
     */
    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * Handle the event.
     */
    public function handle(MarketingInteraction $event): void
    {
        $this->statisticsService->updateStatistics([
            'type' => $event->interactionType,
            'amount' => $event->revenue,
            'campaign_id' => $event->campaignId,
            'store_id' => $event->storeId,
        ]);
    }
}
