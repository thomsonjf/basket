<?php

namespace Acme\Widgets\Sales\Repository;

use Acme\Widgets\Sales\Entity\Product;

/**
 * Interface ProductRepositoryInterface
 * @package Acme\Widgets\Sales\Repository
 */
interface ProductRepositoryInterface
{
    /**
     * Add a product to the repository
     *
     * @param Product $product
     * @return mixed
     */
    public function addProduct(Product $product);

    /**
     * Find all products
     * @return array
     */
    public function findAll(): array;

    /**
     * Find a single product by code
     *
     * @param string $code
     * @return Product|null
     */
    public function findOneByCode(string $code): ?Product;
}
