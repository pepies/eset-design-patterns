<?php

namespace ESET\Shopping;

use Assert\Assertion;
use Money\Money;

class ComboProduct extends Product
{
    private $products;

    public function __construct(
        string $sku,
        string $name,
        ProductList $products,
        Money $price = null
    ) {
        Assertion::minCount($products, 2, 'At least two products required to make a combo');

        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->products = $products;
    }

    public function getPrice(): Money
    {
        return $this->price ?: $this->products->getTotalPrice();
    }
}
