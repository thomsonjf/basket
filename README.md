# ACME Widget Co. Basket Library

PHP 7 Basket Library

**Overview**

The Basket Library is a simple shopping for use with PHP 7.1.1 and above.

**Technical Approach**

The Basket has been approached to provide proper decoupling of product storage/retrieval from the basket logic itself.
Additionally, calculation of discounts and delivery charges is not the concern of the basket but is instead delegated
to helpers.

Delivery charges can be calculated by applying one or more `AbstractDeliveryChargeRule` objects - by way of example the 
`OrderValueBasedDeliveryChargeRule` object allows one or more rules to be applied to define price/order value breaks and the
resultant delivery costs at each range. The basket isn't concerned with how the discount is calculated and the delivery charge 
rule can base on any piece of data from the basket it wishes.

Discounts can be calculated by applying one or more `AbstractDiscountRule` objects which are passed the `Basket` and can
calculate the discount required per line item before reducing to a single figure for subtraction from the goods and delivery 
totals. Similarly, the basket isn't concerned with how the discount is calculated.

The tests assert the examples as per the instructions.

**Assumptions**

The library is fairly simple and is based on the following assumptions:-

1. Special offers/discounts can be stacked - there's no limit
2. Discounts are applied before delivery is calculated (as per examples)
3. Prices are stored against products in a given currency to pave the way for multi-currency support, but final calculations just work with the numbers
4. For delivery pricing breaks, the last rule has no upper limit

**Installation &amp; Usage**

Usage is simple, to install, add the following to your project's `composer.json`:

```
"repositories": [
    {
        "url": "https://github.com/thomsonjf/basket.git",
        "type": "git"
    }
]
```

Then add the library in the usual way using composer:

```
composer require thomsonjf/basket
```

Usage:

```
use Acme\Widgets\Sales\Basket;
use Acme\Widgets\Sales\Repository\ProductRepository;
use Acme\Widgets\Sales\Helper\DeliveryChargeRule\OrderValueBasedDeliveryChargeRule;
use Acme\Widgets\Sales\Helper\DiscountRule\SecondHalfPriceDiscountRule;

// Create a new basket
$basket = new Basket();

// Create a colour and a currency
$usd = new Currency('USD', 'US Dollars', '$');
$red = new Colour('R', 'Red');

// Set product catalogue used to resolve product links (repository pattern)
$repository = new ProductRepository();          // implements ProductRepositoryInterface
$basket->setProductsRepository($repository);

// Add a product to the basket by code (causes lookup to repository)
$this->basket->addProduct('G01');
$this->basket->addProduct('B01');
$this->basket->addProduct('R01');

// Configuring Delivery Rules - specify delivery charge is 4.95 for orders between 0 and 50.00

$basket->addDeliveryChargeRule(
   new OrderValueBasedDeliveryChargeRule(0, 50.00, 4.95)
);

// Configuring Discount Rules - specify buy one get 2nd half price on product R01
$basket->addDiscountRule(
    new SecondHalfPriceDiscountRule(
        new Product('R01', 'Red Widget', $red, new Price(32.95, $usd))
    )
);

// Calculate totals
$basket->calculateDiscount();           // gives the discount amount
$basket->calculateDeliveryCosts();      // gives shipping amount
$basket->calculateOrderValueTotal();    // get goods total

$basket->getGrandTotal();               // get grand total amount
```

**Tests**

```
$ vendor/bin/phpunit --bootstrap vendor/autoload.php --testdox tests   
   PHPUnit 7.5.20 by Sebastian Bergmann and contributors.
   
   Basket
    ✔ Add non existing product
    ✔ One blue one green product
    ✔ Two red products
    ✔ One red one green
    ✔ Two blue three red
   
   Time: 76 ms, Memory: 4.00 MB
   
   OK (5 tests, 9 assertions)
```

