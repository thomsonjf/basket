<?php

namespace Acme\Widgets\Sales\Entity;

/**
 * Class Currency
 * @package Acme\Widgets\Sales\Entity
 */
class Currency
{
    /**
     * Currency Code ISO 4217
     *
     * @var string
     */
    protected $code;

    /**
     * Colour Name
     *
     * @var string
     */
    protected $name;

    /**
     * Currency Symbol
     *
     * @var string
     */
    protected $symbol;

    /**
     * Colour constructor.
     * @param string $id
     * @param string $name
     */
    public function __construct(string $code, string $name, string $symbol)
    {
        $this->code = $code;
        $this->name = $name;
        $this->symbol = $symbol;
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
     * @param string $name
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
     * Get the symbol
     *
     * @return string
     */
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    /**
     * Set the symbol
     *
     * @param string $symbol
     */
    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }
}
