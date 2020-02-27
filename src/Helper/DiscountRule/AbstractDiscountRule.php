<?php

namespace Acme\Widgets\Sales\Helper\DiscountRule;

use Acme\Widgets\Sales\Basket;
use Acme\Widgets\Sales\Entity\Price;
use Acme\Widgets\Sales\Helper\AbstractBasketRule;

/**
 * Class AbstractDiscountRule
 * @package Acme\Widgets\Sales\Helper\DiscountRule
 */
abstract class AbstractDiscountRule extends AbstractBasketRule
{
    /**
     * Get the discount amount
     *
     * @return Price
     */
    abstract public function getDiscount(Basket $basket):Price;
}
