<?php

namespace Acme\Widgets\Sales\Helper\DeliveryChargeRule;

use Acme\Widgets\Sales\Basket;

/**
 * Class OrderValueBasedDeliveryChargeRule
 * @package Acme\Widgets\Sales\Entity\Basket\DeliveryChargeRule
 */
class OrderValueBasedDeliveryChargeRule extends AbstractDeliveryChargeRule
{
    /**
     * Minimum Order Value
     *
     * @var float
     */
    protected $minOrderValue;

    /**
     * Maximum order value
     *
     * @var float
     */
    protected $maxOrderValue;

    /**
     * Delivery charge
     *
     * @var float
     */
    protected $deliveryCharge;

    /**
     * OrderValueBasedDeliveryChargeRule constructor.
     * @param float|null $minOrderValue
     * @param float|null $maxOrderValue
     * @param float $deliveryCharge
     */
    public function __construct(?float $minOrderValue, ?float $maxOrderValue, float $deliveryCharge)
    {
        if (null === $minOrderValue && null === $maxOrderValue) {
            throw new \RuntimeException('Invalid Delivery Charge min/max combination - cannot both be null');
        }

        $this->minOrderValue = $minOrderValue;
        $this->maxOrderValue = $maxOrderValue;
        $this->deliveryCharge = $deliveryCharge;
    }

    /**
     * @inheritDoc
     */
    public function isApplicable(Basket $basket):bool
    {
        $orderValue = $basket->calculateOrderValueTotal() - $basket->calculateDiscount();

        // No minimum, so assume lowest
        if (null === $this->minOrderValue && $orderValue <= $this->maxOrderValue) {
            return true;
        }

        // No maximum, so assume highest
        if (null === $this->maxOrderValue && $orderValue > $this->minOrderValue) {
            return true;
        }

        // Other cases
        return $orderValue > $this->minOrderValue && $orderValue <= $this->maxOrderValue;
    }

    /**
     * @inheritDoc
     */
    public function getDeliveryCharge(Basket $basket):float
    {
        return $this->deliveryCharge;
    }
}
