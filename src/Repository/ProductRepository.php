<?php

namespace Acme\Widgets\Sales\Repository;

use Acme\Widgets\Sales\Entity\Product;

/**
 * Class ProductRepository
 * @package Acme\Widgets\Sales\Repository
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Products are stored here...this isn't real persistence...but encapsulates retrieval of products
     *
     * @var array
     */
    protected $products;

    /**
     * @inheritDoc
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    /**
     * @inheritDoc
     */
    public function findOneByCode(string $code): ?Product
    {
        foreach ($this->products as $product) {
            if (!$product instanceof Product) continue;
            if ($product->getCode() === $code) {
                return $product;
            }
        }
        return null;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this->products;
    }
}
