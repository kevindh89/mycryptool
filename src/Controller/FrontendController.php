<?php

declare(strict_types=1);

namespace App\Controller;


use App\Factory\TradeFactory;
use App\Repository\GdaxRepository;
use App\Repository\TradeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('frontend/home.html.twig');
    }

    /**
     * @Route("/trades", name="trades")
     */
    public function trades(TradeRepository $tradeRepository)
    {
        $trades = $tradeRepository->findAll();

        return $this->render('frontend/trades.html.twig', [
            'trades' => $trades
        ]);
    }

    /**
     * @Route("/store-trades", name="store_trades")
     */
    public function storeTrades(GdaxRepository $gdaxRepository, EntityManagerInterface $entityManager): Response
    {
        $response = json_decode($gdaxRepository->getFills()->getBody()->getContents(), true);

        $trades = [];
        foreach ($response as $tradeResponse) {
            $trade = TradeFactory::fromApiResponse($tradeResponse);
            $trades[] = $trade;
            $entityManager->persist($trade);
        }

        $entityManager->flush();

        return new Response(sprintf('Stored %s trades', count($trades)));
    }
}