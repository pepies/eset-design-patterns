<?php

namespace ESET\Shopping\Coupon;

use Assert\Assertion;
use ESET\Shopping\Order;
use Money\Money;

final class RateCoupon implements Coupon
{
    private $code;
    private $rate;

    public function __construct(string $code, float $rate)
    {
        Assertion::between($rate, 0.01, 1);

        $this->code = $code;
        $this->rate = $rate;
    }

    public static function fromPercentage(string $code, float $percentage): self
    {
        Assertion::between($percentage, 1, 100);

        return new self($code, $percentage / 100);
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function apply(Order $order): Money
    {
        $totalAmount = $order->getTotalAmount();

        return $totalAmount->subtract($totalAmount->multiply($this->rate));
    }
}
