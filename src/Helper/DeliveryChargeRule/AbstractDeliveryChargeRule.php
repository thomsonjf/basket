<?php

namespace Acme\Widgets\Sales\Helper\DeliveryChargeRule;

use Acme\Widgets\Sales\Basket;
use Acme\Widgets\Sales\Helper\AbstractBasketRule;

/**
 * Class AbstractDeliveryChargeRule
 * @package Acme\Widgets\Sales\Helper\DeliveryChargeRule
 */
abstract class AbstractDeliveryChargeRule extends AbstractBasketRule
{
    /**
     * Get the delivery charge amount
     *
     * @return float
     */
    abstract public function getDeliveryCharge(Basket $basket):float;
}
