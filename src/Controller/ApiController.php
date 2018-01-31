<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exchange\Gdax\Client;
use App\Sync\GdaxApiSyncService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ApiController
{
    /**
     * @Route("/rates", name="rates")
     */
    public function rates(Client $client): Response
    {
        $rates = $client->getRate('ETH-EUR');

        return new Response(
            '<pre>' . json_encode($rates, JSON_PRETTY_PRINT) . '</pre>'
        );
    }

    /**
     * @Route("/trades", name="trades")
     */
    public function trades(Request $request, Client $client): Response
    {
        $lastTradeId = $request->query->get('cb-before', null);
        $trades = $lastTradeId !== null ?
            $client->getTradesBefore($lastTradeId) :
            $client->getTrades();

        return new Response(
            '<pre>' . json_encode($trades, JSON_PRETTY_PRINT) . '</pre>'
        );
    }

    /**
     * @Route("/orders", name="orders")
     */
    public function orders(Client $gdaxRepository): Response
    {
        $orders = $gdaxRepository->getOrders();

        return new Response(
            '<pre>' . json_encode($orders, JSON_PRETTY_PRINT) . '</pre>'
        );
    }

    /**
     * @Route("/collect-trades", name="collect_trades")
     */
    public function collectTrades(GdaxApiSyncService $syncService): Response
    {
        $syncedTradeCount = $syncService->fetchTrades();

        return new Response(sprintf('Stored %s trades', $syncedTradeCount));
    }

    /**
     * @Route("/refresh-orders", name="collect_orders")
     */
    public function refreshOrders(GdaxApiSyncService $syncService): Response
    {
        $syncedOrdersCount = $syncService->refreshOrders();

        return new Response(sprintf('Stored %s orders', $syncedOrdersCount));
    }
}
