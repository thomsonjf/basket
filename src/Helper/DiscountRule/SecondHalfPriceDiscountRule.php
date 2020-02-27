<?php

namespace Acme\Widgets\Sales\Helper\DiscountRule;

use Acme\Widgets\Sales\Basket;
use Acme\Widgets\Sales\Entity\LineItem;
use Acme\Widgets\Sales\Entity\Price;
use Acme\Widgets\Sales\Entity\Product;

/**
 * Class SecondHalfPriceDiscountRule
 * @package Acme\Widgets\Sales\Helper\DiscountRule
 */
class SecondHalfPriceDiscountRule extends AbstractDiscountRule
{
    /**
     * The product that's two for one
     *
     * @var Product
     */
    protected $product;

    /**
     * TwoForOneDiscountRule constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @inheritDoc
     */
    public function isApplicable(Basket $basket): bool
    {
        foreach ($basket->getBasketItems() as $item) {
            if (!$item instanceof LineItem) continue;
            if ($item->getProduct()->getCode() === $this->product->getCode() && $item->getQuantity() >= 2) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function getDiscount(Basket $basket): Price
    {
        $discountedProductItem = null;
        foreach ($basket->getBasketItems() as $item) {
            if (!$item instanceof LineItem) continue;
            if ($item->getProduct()->getCode() === $this->product->getCode() && $item->getQuantity() >= 2) {
                return new Price(
                    floor($item->getQuantity() / 2) * ($item->getProduct()->getPrice()->getPrice() / 2),
                    $item->getProduct()->getPrice()->getCurrency()
                );

                break;
            }
        }

        return null;
    }
}