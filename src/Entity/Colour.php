<?php

namespace Acme\Widgets\Sales\Entity;

/**
 * Class Colour
 * @package Acme\Widgets\Sales\Entity
 */
class Colour
{
    /**
     * Colour ID
     *
     * @var string
     */
    protected $id;

    /**
     * Colour Name
     *
     * @var string
     */
    protected $name;

    /**
     * Colour constructor.
     * @param string $id
     * @param string $name
     */
    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
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
}
