<?php

namespace App\Listeners;

use App\Events\TicketPurchased;
use App\Services\StatisticsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStatisticsOnTicketPurchase implements ShouldQueue
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
    public function handle(TicketPurchased $event): void
    {
        $this->statisticsService->updateStatistics([
            'type' => 'ticket_sale',
            'amount' => $event->ticketPrice,
            'store_id' => $event->storeId,
        ]);
    }
}
