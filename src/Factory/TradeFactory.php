<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Trade;
use DateTime;

class TradeFactory
{
    public static function fromApiResponse(array $response): Trade
    {
        return new Trade(
            $response['trade_id'],
            new DateTime($response['created_at']),
            $response['product_id'],
            $response['order_id'],
            $response['user_id'],
            $response['profile_id'],
            $response['liquidity'],
            (float) $response['price'],
            (float) $response['size'],
            (float) $response['fee'],
            $response['side'],
            $response['settled']
        );
    }
}
