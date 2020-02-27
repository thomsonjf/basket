<?php

use PHPUnit\Framework\TestCase;
use Acme\Widgets\Sales\Basket;
use Acme\Widgets\Sales\Repository\ProductRepository;
use Acme\Widgets\Sales\Entity\Colour;
use Acme\Widgets\Sales\Entity\Currency;
use Acme\Widgets\Sales\Entity\Price;
use Acme\Widgets\Sales\Entity\Product;
use Acme\Widgets\Sales\Helper\DeliveryChargeRule\OrderValueBasedDeliveryChargeRule;
use Acme\Widgets\Sales\Helper\DiscountRule\SecondHalfPriceDiscountRule;

/**
 * Class BasketTest
 */
final class BasketTest extends TestCase
{
    /**
     * Create and initialise the basket with products and rules
     *
     * @var Basket
     */
    protected $basket;

    /**
     * Sort repository, currency, products, colours, delivery charge and discount rules
     */
    public function setUp()
    {
        // currencies
        $usd = new Currency('USD', 'US Dollars', '$');

        // colours
        $red = new Colour('R', 'Red');
        $green = new Colour('G', 'Green');
        $blue = new Colour('B', 'Blue');

        // products

        $redWidget = new Product('R01', 'Red Widget', $red, new Price(32.95, $usd));
        $greenWidget = new Product('G01', 'Green Widget', $green, new Price(24.95, $usd));
        $blueWidget = new Product('B01', 'Blue Widget', $blue, new Price(7.95, $usd));

        // sort repo
        $repository = new ProductRepository();
            $repository->addProduct($redWidget);
            $repository->addProduct($blueWidget);
            $repository->addProduct($greenWidget);

        $this->basket = new Basket();

        $this->basket->setProductsRepository($repository);

        // add on delivery cost rules
        $this->basket->addDeliveryChargeRule(
           new OrderValueBasedDeliveryChargeRule(0, 50.00, 4.95)
        );
        $this->basket->addDeliveryChargeRule(
            new OrderValueBasedDeliveryChargeRule(50.01, 90.00, 2.95)
        );
        $this->basket->addDeliveryChargeRule(
            new OrderValueBasedDeliveryChargeRule(90.01, null, 0.00)
        );

        // register a buy one get one free on red widgets
        $this->basket->addDiscountRule(
            new SecondHalfPriceDiscountRule($redWidget)
        );
    }

    /**
     * Test adding a non existing product
     */
    public function testAddNonExistingProduct()
    {
        $this->expectException(RuntimeException::class);
        $this->basket->addProduct('NaN');
    }

    /**
     * Test one blue and one green product (SCENARIO 1)
     */
    public function testOneBlueOneGreenProduct()
    {
        $this->basket->addProduct('G01');
        $this->basket->addProduct('B01');

        $this->assertCount(2, $this->basket->getBasketItems());
        $this->assertEquals($this->basket->getGrandTotal(), 37.85);
    }

    /**
     * Test two red products (SCENARIO 2)
     */
    public function testTwoRedProducts()
    {
        $this->basket->addProduct('R01');
        $this->basket->addProduct('R01');

        $this->assertCount(1, $this->basket->getBasketItems());
        $this->assertEquals($this->basket->getGrandTotal(), 54.375);
    }

    /**
     * Test two red products (SCENARIO 3)
     */
    public function testOneRedOneGreen()
    {
        $this->basket->addProduct('R01');
        $this->basket->addProduct('G01');

        $this->assertCount(2, $this->basket->getBasketItems());
        $this->assertEquals($this->basket->getGrandTotal(), 60.85);
    }

    /**
     * Test two blue widgets and three red widgets (SCENARIO 4)
     */
    public function testTwoBlueThreeRed()
    {
        $this->basket->addProduct('B01');
        $this->basket->addProduct('B01');
        $this->basket->addProduct('R01');
        $this->basket->addProduct('R01');
        $this->basket->addProduct('R01');

        $this->assertCount(2, $this->basket->getBasketItems());
        $this->assertEquals($this->basket->getGrandTotal(), 98.275);
    }
}
