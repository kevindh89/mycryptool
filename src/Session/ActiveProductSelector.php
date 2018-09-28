<?php

namespace App\Session;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ActiveProductSelector
{
    const AVAILABLE_PRODUCTS = ['BTC-EUR', 'BCH-EUR', 'ETH-EUR', 'LTC-EUR'];
    const DEFAULT_ACTIVE_PRODUCT = 'BTC-EUR';
    const ACTIVE_PRODUCT_SESSION = 'activeProduct';

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function setActiveProduct(string $product): void
    {
        if (!in_array($product, self::AVAILABLE_PRODUCTS)) {
            throw new NotFoundHttpException(sprintf(
                'Product %s is not allowed, should be one of: %s',
                $product,
                implode(',', self::AVAILABLE_PRODUCTS)
            ));
        }

        $this->session->set(self::ACTIVE_PRODUCT_SESSION, $product);
    }

    public function getActiveProduct(): string
    {
        return $this->session->get(self::ACTIVE_PRODUCT_SESSION, self::DEFAULT_ACTIVE_PRODUCT);
    }

    public function getPrimaryActiveProduct(): string
    {
        return strstr($this->session->get(self::ACTIVE_PRODUCT_SESSION), '-', true);
    }

    public function getSecondayActiveProduct(): string
    {
        return strstr($this->session->get(self::ACTIVE_PRODUCT_SESSION), '-');
    }
}
