<?php

namespace ESET\Shopping;

use Money\Money;

class PhysicalProduct extends Product
{
    private $shippingFees;

    public function __construct(
        string $sku,
        string $name,
        Money $price
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    public function setShippingFees(Money $shippingFees): void
    {
        $this->shippingFees = $shippingFees;
    }
}
