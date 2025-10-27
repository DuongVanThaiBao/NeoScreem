<?php

namespace App\Helpers;

use App\Events\TicketPurchased;
use App\Events\MarketingInteraction;

class StatisticsHelper
{
    /**
     * Ghi nhận việc mua vé
     */
    public static function recordTicketPurchase($ticketPrice, $storeId = null, $quantity = 1)
    {
        event(new TicketPurchased($ticketPrice, $storeId, $quantity));
    }

    /**
     * Ghi nhận tương tác marketing (click)
     */
    public static function recordMarketingClick($campaignId = null, $storeId = null)
    {
        event(new MarketingInteraction('click', $campaignId, 0, $storeId));
    }

    /**
     * Ghi nhận chuyển đổi marketing (conversion)
     */
    public static function recordMarketingConversion($revenue, $campaignId = null, $storeId = null)
    {
        event(new MarketingInteraction('conversion', $campaignId, $revenue, $storeId));
    }
}
