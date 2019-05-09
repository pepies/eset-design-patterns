<?php

namespace Tests\ESET\Shopping;

use ESET\Shopping\ComboProduct;
use ESET\Shopping\PhysicalProduct;
use Money\Money;
use PHPUnit\Framework\TestCase;

final class ComboProductTest extends TestCase
{
    public function testComboPriceEqualsAllProductPricesSum(): void
    {
        $products = [
            new PhysicalProduct('ABC1234', 'Product A', Money::EUR(9390)),
            new PhysicalProduct('DEF8394', 'Product B', Money::EUR(1675)),
            new ComboProduct('YYY8394', 'Product C', [
                new PhysicalProduct('ZZZ1234', 'Product D', Money::EUR(2385)),
                new PhysicalProduct('WWW8394', 'Product E', Money::EUR(4200)),
            ]),
        ];

        $product = new ComboProduct(
            'XXX9374',
            'Super Product',
            $products
        );

        $this->assertEquals(Money::EUR(17650), $product->getPrice());
    }

    public function testComboHasFixedPrice(): void
    {
        $products = [
            new PhysicalProduct('ABC1234', 'Product A', Money::EUR(9390)),
            new PhysicalProduct('DEF8394', 'Product B', Money::EUR(1675)),
        ];

        $product = new ComboProduct(
            'XXX9374',
            'Super Product',
            $products,
            Money::EUR(10000)
        );

        $this->assertEquals(Money::EUR(10000), $product->getPrice());
    }
}
