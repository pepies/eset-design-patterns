<?php

namespace ESET\Shopping;

use Money\Money;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }
}
