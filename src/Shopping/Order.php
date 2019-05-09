<?php

namespace ESET\Shopping;

use Money\Money;

class Order
{
    private $totalAmount;

    public function __construct(Money $totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    public function getTotalAmount(): Money
    {
        return $this->totalAmount;
    }
}
