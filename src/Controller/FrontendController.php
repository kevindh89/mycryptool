<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Trade;
use App\Exchange\Gdax\Client;
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
    public function trades(ActiveProductSelector $productSelector, Client $client)
    {
        $gainsLossesPerDay = [];

        $trades = $client->getTrades($productSelector->getActiveProduct());
        $groupedTrades = $this->groupTradesPerOrderId($trades);

        foreach ($groupedTrades as $trade) {
            $tradeDate = $trade->getTradeCreatedAt()->format('d-m-Y');
            $gainsLossesPerDay[$tradeDate] =
                isset($gainsLossesPerDay[$tradeDate]) ?
                    $gainsLossesPerDay[$tradeDate] :
                    [
                        'EUR' => 0,
                        $productSelector->getPrimaryActiveProduct() => 0,
                    ];

            if ($trade->getSide() === 'buy') {
                $gainsLossesPerDay[$tradeDate]['EUR'] -= $trade->getPrice() * $trade->getSize();
                $gainsLossesPerDay[$tradeDate][$productSelector->getPrimaryActiveProduct()] += $trade->getSize();
            } else {
                $gainsLossesPerDay[$tradeDate]['EUR'] += $trade->getPrice() * $trade->getSize();
                $gainsLossesPerDay[$tradeDate][$productSelector->getPrimaryActiveProduct()] -= $trade->getSize();
            }

            $gainsLossesPerDay[$tradeDate]['EUR'] -= $trade->getFee();
        }

        return $this->render('frontend/trades.html.twig', [
            'trades' => $groupedTrades,
            'gainsLossesPerDay' => $gainsLossesPerDay,
            'primaryActiveProduct' => $productSelector->getPrimaryActiveProduct(),
        ]);
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
     * @param array $trades
     *
     * @return Trade[]
     */
    public function groupTradesPerOrderId(array $trades)
    {
        $groupedTrades = [];

        /** @var Trade $trade */
        foreach ($trades as $trade) {
            if (!isset($groupedTrades[$trade->getOrderId()])) {
                $groupedTrades[$trade->getOrderId()] = $trade;

                continue;
            }

            /** @var Trade $groupedTrade */
            $groupedTrade = $groupedTrades[$trade->getOrderId()];

            $totalSize = $groupedTrade->getSize() + $trade->getSize();
            $averagePrice = ($groupedTrade->getSize() * $groupedTrade->getPrice() + $trade->getSize() * $trade->getPrice()) / $totalSize;
            $tradeCreatedAt = ($groupedTrade->getTradeCreatedAt() > $trade->getTradeCreatedAt()) ?
                $groupedTrade->getTradeCreatedAt() :
                $trade->getTradeCreatedAt();
            $totalFee = $groupedTrade->getFee() + $trade->getFee();

            $groupedTrade->setPrice($averagePrice);
            $groupedTrade->setSize($totalSize);
            $groupedTrade->setTradeCreatedAt($tradeCreatedAt);
            $groupedTrade->setFee($totalFee);

            $groupedTrades[$trade->getOrderId()] = $groupedTrade;
        }

        return array_values($groupedTrades);
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
