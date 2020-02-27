<?php

namespace Acme\Widgets\Sales\Entity;

/**
 * Class Product
 * @package Acme\Widgets\Sales\Entity
 */
class Product
{
    /**
     * Product Code
     *
     * @var string
     */
    protected $code;

    /**
     * Product Name
     *
     * @var string
     */
    protected $name;

    /**
     * Product colour
     *
     * @var Colour
     */
    protected $colour;

    /**
     * Product price + currency
     *
     * @var Price
     */
    protected $price;

    /**
     * Product constructor.
     * @param string $code
     * @param string $name
     * @param Colour $colour
     * @param Price $price
     */
    public function __construct(string $code, string $name, Colour $colour, Price $price)
    {
        $this->code = $code;
        $this->name = $name;
        $this->colour = $colour;
        $this->price = $price;
    }

    /**
     * Get the code
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set the code
     *
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Get the name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the name
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get the colour
     *
     * @return Colour
     */
    public function getColour(): Colour
    {
        return $this->colour;
    }

    /**
     * Set the colour
     *
     * @param Colour $colour
     */
    public function setColour(Colour $colour): void
    {
        $this->colour = $colour;
    }

    /**
     * Get the price
     *
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * Set the price
     *
     * @param Price $price
     */
    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }
}
