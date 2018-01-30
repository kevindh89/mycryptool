<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exchange\GdaxExchange;
use App\Factory\TradeFactory;
use App\Repository\GdaxRepository;
use App\Repository\TradeRepository;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
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
    public function rates(GdaxRepository $gdaxRepository): Response
    {
        $response = $gdaxRepository->getRate('ETH-EUR')->getBody()->getContents();
        return new Response(
            '<pre>'. json_encode(json_decode($response), JSON_PRETTY_PRINT) .'</pre>'
        );
    }

    /**
     * @Route("/trades", name="orders")
     */
    public function trades(Request $request, GdaxRepository $gdaxRepository): Response
    {
        $response = $gdaxRepository
            ->getFills($request->query->get('cb-before', ''))
            ->getBody()
            ->getContents();

//        $lastTradeId = $gdaxRepository->getFills()->getHeader('CB-BEFORE')[0];

        return new Response(
            '<pre>'. json_encode(json_decode($response), JSON_PRETTY_PRINT) .'</pre>'
        );
    }

    /**
     * @Route("/collect-trades", name="collect_trades")
     */
    public function collectTrades(
        GdaxRepository $gdaxRepository,
        TradeRepository $tradeRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $lastTrade = $tradeRepository->findOneBy([], ['tradeId' => 'DESC']);
        $response = $lastTrade !== null ?
            $gdaxRepository->getFillsBefore($lastTrade->getTradeId()) :
            $gdaxRepository->getFills();
        $tradesResponse = json_decode($response->getBody()->getContents(), true);

        $trades = [];
        foreach ($tradesResponse as $singleTradeInResponse) {
            $trade = TradeFactory::fromApiResponse($singleTradeInResponse);
            $trades[] = $trade;
            $entityManager->persist($trade);
        }

        $entityManager->flush();

        return new Response(sprintf('Stored %s trades', count($trades)));
    }
}
