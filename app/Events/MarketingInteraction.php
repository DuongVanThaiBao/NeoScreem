<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MarketingInteraction
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $interactionType; // 'click' or 'conversion'
    public $campaignId;
    public $revenue;
    public $storeId;

    /**
     * Create a new event instance.
     */
    public function __construct($interactionType, $campaignId = null, $revenue = 0, $storeId = null)
    {
        $this->interactionType = $interactionType;
        $this->campaignId = $campaignId;
        $this->revenue = $revenue;
        $this->storeId = $storeId;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('statistics-updates'),
        ];
    }
}
