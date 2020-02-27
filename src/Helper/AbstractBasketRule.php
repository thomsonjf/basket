<?php

namespace Acme\Widgets\Sales\Helper;

use Acme\Widgets\Sales\Basket;

/**
 * Class AbstractBasketRule
 * @package Acme\Widgets\Sales\Helper
 */
abstract class AbstractBasketRule
{
    /**
     * Given the current basket state, does this delivery charge rule apply?
     *
     * @param Basket $basket
     * @return bool
     */
    abstract public function isApplicable(Basket $basket):bool;
}
