<?php

namespace App\Session;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ActiveProductSelector
{
    const AVAILALBE_PRODUCTS = ['BTC-EUR', 'BCH-EUR', 'ETH-EUR', 'LTC-EUR'];
    const DEFAULT_ACTIVE_PRODUCT = ['BTC-EUR'];

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function setActiveProduct(string $product): void
    {
        if (!in_array($product, self::AVAILALBE_PRODUCTS)) {
            throw new NotFoundHttpException(sprintf(
                'Product %s is not allowed, should be one of: %s',
                $product,
                implode(',', self::AVAILALBE_PRODUCTS)
            ));
        }

        $this->session->set('activeProduct', $product);
    }

    public function getActiveProduct(): string
    {
        return $this->session->get('activeProduct', self::DEFAULT_ACTIVE_PRODUCT);
    }
}
