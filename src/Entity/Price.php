<?php

namespace Acme\Widgets\Sales\Entity;

/**
 * Class Price
 * @package Acme\Widgets\Sales\Entity
 */
class Price
{
    /**
     * Scalar price
     *
     * @var float
     */
    protected $price;

    /**
     * Current currency
     *
     * @var Currency
     */
    protected $currency;

    /**
     * Price constructor.
     * @param float $price
     * @param Currency $currency
     */
    public function __construct(float $price, Currency $currency)
    {
        $this->price = $price;
        $this->currency = $currency;
    }

    /**
     * Get the price
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Get the currency
     *
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }
}
