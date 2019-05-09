<?php

namespace ESET\Shopping;

use Assert\Assertion;
use Money\Money;

class ComboProduct extends Product
{
    /** @var Product[] */
    private $products;

    public function __construct(
        string $sku,
        string $name,
        array $products,
        Money $price = null
    ) {
        Assertion::allIsInstanceOf($products, Product::class, 'Products must be a list of Product instances.');
        Assertion::minCount($products, 2, 'At least two products required to make a combo');

        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->products = array_values($products);
    }

    public function getPrice(): Money
    {
        if ($this->price) {
            return $this->price;
        }

        $totalPrice = $this->products[0]->getPrice();
        $nbProducts = \count($this->products);
        for ($i = 1; $i < $nbProducts; $i++) {
            $totalPrice = $totalPrice->add($this->products[$i]->getPrice());
        }

        return $totalPrice;
    }
}
