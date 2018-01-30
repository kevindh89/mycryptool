<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Order;
use DateTime;

class OrderFactory
{
    public static function fromApiResponse(array $response): Order
    {
        return new Order(
            $response['id'],
            new DateTime($response['created_at']),
            $response['product_id'],
            (float) $response['price'],
            (float) $response['size'],
            (float) $response['fill_fees'],
            $response['side'],
            $response['settled'],
            $response['stp'],
            $response['type'],
            $response['time_in_force'],
            (float) $response['filled_size'],
            (float) $response['executed_value'],
            $response['status']
        );
    }
}
