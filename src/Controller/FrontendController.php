<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\TradeRepository;
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
    public function trades(TradeRepository $repository)
    {
        $trades = $repository->findBy([], ['tradeCreatedAt' => 'DESC']);

        return $this->render('frontend/trades.html.twig', [
            'trades' => $trades
        ]);
    }
    
    /**
     * @Route("/orders", name="orders")
     */
    public function orders(OrderRepository $repository)
    {
        $orders = $repository->findBy([], ['orderCreatedAt' => 'DESC']);

        return $this->render('frontend/orders.html.twig', [
            'orders' => $orders
        ]);
    }
}