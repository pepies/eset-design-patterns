<?php

namespace ESET\Shopping;

use Assert\Assertion;
use Money\Money;

class ProductList implements \Countable
{
    /** @var Product[] */
    private $products;

    public function __construct(array $products = [])
    {
        Assertion::allIsInstanceOf($products, Product::class, 'Products must be a list of Product instances.');

        $this->products = array_values($products);
    }

    public function getTotalPrice(): Money
    {
        $totalPrice = $this->products[0]->getPrice();
        $nbProducts = \count($this->products);
        for ($i = 1; $i < $nbProducts; $i++) {
            $totalPrice = $totalPrice->add($this->products[$i]->getPrice());
        }

        return $totalPrice;
    }

    public function count(): int
    {
        return \count($this->products);
    }
}
