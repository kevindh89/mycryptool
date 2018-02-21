<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exchange\Gdax\Client;
use App\Session\ActiveProductSelector;
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
     * @Route("/rate/{product}", name="rates")
     */
    public function rates(string $product, Client $client): Response
    {
        return new Response($client->getRate($product));
    }

    /**
     * @Route("/trades", name="trades")
     */
    public function trades(Request $request, Client $client, ActiveProductSelector $productSelector): Response
    {
        $lastTradeId = $request->query->get('cb-before', null);
        $activeProduct = $productSelector->getActiveProduct();

        $trades = $lastTradeId !== null ?
            $client->getTradesBefore($activeProduct, $lastTradeId) :
            $client->getTrades($activeProduct);

        return new Response(
            '<pre>' . json_encode($trades, JSON_PRETTY_PRINT) . '</pre>'
        );
    }

    /**
     * @Route("/orders", name="orders")
     */
    public function orders(Client $gdaxRepository, ActiveProductSelector $productSelector): Response
    {
        $orders = $gdaxRepository->getOrders($productSelector->getActiveProduct());

        return new Response(
            '<pre>' . json_encode($orders, JSON_PRETTY_PRINT) . '</pre>'
        );
    }

    /**
     * @Route("/collect-trades", name="collect_trades")
     */
    public function collectTrades(GdaxApiSyncService $syncService, ActiveProductSelector $productSelector): Response
    {
        $syncedTradeCount = $syncService->fetchTrades($productSelector->getActiveProduct());

        return new Response(sprintf('Stored %s trades', $syncedTradeCount));
    }

    /**
     * @Route("/refresh-orders", name="collect_orders")
     */
    public function refreshOrders(GdaxApiSyncService $syncService, ActiveProductSelector $productSelector): Response
    {
        $syncedOrdersCount = $syncService->refreshOrders($productSelector->getActiveProduct());

        return new Response(sprintf('Stored %s orders', $syncedOrdersCount));
    }
}
