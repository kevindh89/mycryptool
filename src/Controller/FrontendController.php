<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exchange\Gdax\Client;
use App\Repository\TradeRepository;
use App\Session\ActiveProductSelector;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(Client $client): Response
    {
        $gdaxAccounts = $client->getAccounts();

        $rates = [];
        foreach ($gdaxAccounts as $gdaxAccount) {
            $rates[$gdaxAccount['currency']] = $gdaxAccount['currency'] !== 'EUR' ?
                $client->getRate($gdaxAccount['currency'] . '-EUR') :
                '';
        }

        return $this->render('frontend/dashboard.html.twig', [
            'accounts' => $gdaxAccounts,
            'rates' => $rates,
        ]);
    }

    /**
     * @Route("/select-active-product", name="select-active-product")
     */
    public function selectActiveProduct(Request $request, ActiveProductSelector $productSelector): Response
    {
        if ($request->query->get('product')) {
            $product = $request->query->get('product', 'BTC-EUR');
            $productSelector->setActiveProduct($product);
        }

        return $this->redirect($this->generateUrl('dashboard'));
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
    public function orders(Client $client, ActiveProductSelector $productSelector)
    {
        $orders = $client->getOrders($productSelector->getActiveProduct());

        return $this->render('frontend/orders.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/trade-list", name="trade-list")
     */
    public function tradeList(TradeRepository $repository, ActiveProductSelector $productSelector)
    {
        $gainsLossesPerDay = [];
        $groupedTrades = $repository->getGroupedTrades($productSelector->getActiveProduct());

        foreach ($groupedTrades as $trade) {
            $gainsLossesPerDay[$trade->getTradeCreatedAt()->format('d-m-Y')] =
                isset($gainsLossesPerDay[$trade->getTradeCreatedAt()->format('d-m-Y')]) ?
                $gainsLossesPerDay[$trade->getTradeCreatedAt()->format('d-m-Y')] :
                [
                    'EUR' => 0,
                    $productSelector->getPrimaryActiveProduct() => 0,
                ];

            if ($trade->getSide() === 'buy') {
                $gainsLossesPerDay[$trade->getTradeCreatedAt()->format('d-m-Y')]['EUR'] -= $trade->getAveragePrice() * $trade->getSize();
                $gainsLossesPerDay[$trade->getTradeCreatedAt()->format('d-m-Y')][$productSelector->getPrimaryActiveProduct()] += $trade->getSize();
            } else {
                $gainsLossesPerDay[$trade->getTradeCreatedAt()->format('d-m-Y')]['EUR'] += $trade->getAveragePrice() * $trade->getSize();
                $gainsLossesPerDay[$trade->getTradeCreatedAt()->format('d-m-Y')][$productSelector->getPrimaryActiveProduct()] -= $trade->getSize();
            }

            $gainsLossesPerDay[$trade->getTradeCreatedAt()->format('d-m-Y')]['EUR'] -= $trade->getFee();
        }

        return $this->render('frontend/trade-list.html.twig', [
            'trades' => $groupedTrades,
            'gainsLossesPerDay' => $gainsLossesPerDay,
            'primaryActiveProduct' => $productSelector->getPrimaryActiveProduct(),
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
