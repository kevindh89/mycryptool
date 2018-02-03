<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Repository\TradeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('frontend/home.html.twig', [
            'meme' => $this->getRandomMeme(),
        ]);
    }

    /**
     * @Route("/trades", name="trades")
     */
    public function trades()
    {
        return $this->render('frontend/trades.html.twig');
    }

    /**
     * @Route("/orders", name="orders")
     */
    public function orders()
    {
        return $this->render('frontend/orders.html.twig');
    }

    /**
     * @Route("/trade-list", name="trade-list")
     */
    public function tradeList(TradeRepository $repository)
    {
        $trades = $repository->findBy([], ['tradeCreatedAt' => 'DESC']);

        return $this->render('frontend/trade-list.html.twig', [
            'trades' => $trades,
        ]);
    }

    /**
     * @Route("/order-list", name="order-list")
     */
    public function orderList(OrderRepository $repository)
    {
        $orders = $repository->findBy([], ['orderCreatedAt' => 'DESC']);

        return $this->render('frontend/order-list.html.twig', [
            'orders' => $orders,
        ]);
    }

    private function getRandomMeme(): string
    {
        $memes = new Finder();
        $memes->files()->in(__DIR__ . '/../../public/images/memes/');

        $files = [];
        foreach ($memes as $meme) {
            $files[] = $meme->getRelativePathname();
        }

        return $files[array_rand($files)];
    }
}
