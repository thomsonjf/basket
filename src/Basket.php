<?php

namespace Acme\Widgets\Sales;

use Acme\Widgets\Sales\Entity\LineItem;
use Acme\Widgets\Sales\Helper\DiscountRule\AbstractDiscountRule;
use Acme\Widgets\Sales\Helper\DeliveryChargeRule\AbstractDeliveryChargeRule;
use Acme\Widgets\Sales\Repository\ProductRepository;
use Acme\Widgets\Sales\Repository\ProductRepositoryInterface;

/**
 * Class Basket
 * @package Acme\Widgets\Sales
 */
class Basket
{
    /**
     * List of discount offer rules
     *
     * @var array<AbstractDiscountRule>
     */
    protected $discountRules = [];

    /**
     * List of active delivery charge rules
     *
     * @var array<AbstractDeliveryChargeRule>
     */
    protected $deliveryChargeRules = [];

    /**
     * List of products currently in the basket, with quantities
     *
     * @var array<LineItem>
     */
    protected $items = [];

    /**
     * Product Repository
     *
     * @var ProductRepositoryInterface
     */
    protected $productsRepository;

    /**
     * Basket constructor.
     */
    public function __construct()
    {
        $this->productsRepository = new ProductRepository();
    }

    /**
     * Add product to the basket
     *
     * @param string $code
     * @return bool
     */
    public function addProduct(string $code):bool
    {
        $product = $this->productsRepository->findOneByCode($code);
        if (null === $product) {
            throw new \RuntimeException(
                sprintf('Product with code [%s] is not valid and could not be added', $code)
            );
        }

        // product is in the list
        foreach ($this->items as $key => $item) {
            if ($item->getProduct()->getCode() === $product->getCode()) {
                $item->incrementQuantity();
                $this->items[$key] = $item;
                return true;
            }
        }

        // product not in the list yet
        $this->items[] = new LineItem($product);

        return true;
    }

    /**
     * Calculate the order value total
     *
     * @return float
     */
    public function calculateOrderValueTotal(): float
    {
        $total = (float)0;
        foreach ($this->items as $item) {
            if (!$item instanceof LineItem) continue;
            $total += $item->getProduct()->getPrice()->getPrice() * $item->getQuantity();
        }

        return $total;
    }

    /**
     * Get the grand total - shipping + goods - discount
     *
     * @return float
     */
    public function getGrandTotal()
    {
        return $this->calculateOrderValueTotal() + $this->calculateDeliveryCosts() - $this->calculateDiscount();
    }

    /**
     * Get basket items
     *
     * @return array<LineItem>
     */
    public function getBasketItems(): array
    {
        return $this->items;
    }

    /**
     *
     *
     * @param AbstractDiscountRule $discountRule
     */
    public function addDiscountRule(AbstractDiscountRule $discountRule)
    {
       $this->discountRules[] = $discountRule;
    }

    /**
     * Add delivery charge rules
     *
     * @param AbstractDeliveryChargeRule $deliveryChargeRule
     */
    public function addDeliveryChargeRule(AbstractDeliveryChargeRule $deliveryChargeRule)
    {
        $this->deliveryChargeRules[] = $deliveryChargeRule;
    }

    /**
     * Get the products repository instance
     *
     * @return ProductRepositoryInterface
     */
    public function getProductsRepository():ProductRepositoryInterface
    {
        return $this->productsRepository;
    }

    /**
     * Set the products repository instance
     *
     * @param ProductRepositoryInterface $productRepository
     */
    public function setProductsRepository(ProductRepositoryInterface $productRepository)
    {
        $this->productsRepository = $productRepository;
    }

    /**
     * Calculate delivery costs using the applicable rules
     *
     * @return float
     */
    public function calculateDeliveryCosts():float
    {
        foreach ($this->deliveryChargeRules as $deliveryChargeRule) {
            if (!$deliveryChargeRule instanceof AbstractDeliveryChargeRule) continue;
            if ($deliveryChargeRule->isApplicable($this)) {
                return $deliveryChargeRule->getDeliveryCharge($this);
            }
        }

        return (float)0;
    }

    /**
     * Calculate discount using the applicable rules
     *
     * @return float
     */
    public function calculateDiscount(): float
    {
        $discount = (float)0;
        foreach ($this->discountRules as $discountRule) {
            if (!$discountRule instanceof AbstractDiscountRule) continue;
            if ($discountRule->isApplicable($this)) {
                $discount += $discountRule->getDiscount($this)->getPrice();
            }
        }

        return $discount;
    }
}
