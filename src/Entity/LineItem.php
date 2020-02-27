<?php

namespace Acme\Widgets\Sales\Entity;

/**
 * Class LineItem
 * @package Acme\Widgets\Sales\Entity
 */
class LineItem
{
    /**
     * The product reference
     *
     * @var Product
     */
    protected $product;

    /**
     * Holds quantity of products on this line item
     *
     * @var int
     */
    protected $quantity;

    /**
     * LineItem constructor.
     * @param Product $product
     * @param int $quantity
     */
    public function __construct(Product $product, $quantity = 1)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * Get the product
     *
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * Get the current quantity
     *
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Set the current quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * Increment quantity by the given step
     *
     * @param int $step
     */
    public function incrementQuantity($step = 1)
    {
        $this->quantity += $step;
    }
}
