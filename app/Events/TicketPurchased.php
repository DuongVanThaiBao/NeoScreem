<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketPurchased
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticketPrice;
    public $storeId;
    public $quantity;

    /**
     * Create a new event instance.
     */
    public function __construct($ticketPrice, $storeId = null, $quantity = 1)
    {
        $this->ticketPrice = $ticketPrice;
        $this->storeId = $storeId;
        $this->quantity = $quantity;
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
