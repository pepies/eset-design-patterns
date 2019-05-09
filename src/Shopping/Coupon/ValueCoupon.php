<?php

namespace ESET\Shopping\Coupon;

use ESET\Shopping\Order;
use Money\Money;

final class ValueCoupon implements Coupon
{
    private $code;
    private $discount;

    public function __construct(
        string $code,
        Money $discount
    ) {
        $this->code = $code;
        $this->discount = $discount;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDiscount(): Money
    {
        return $this->discount;
    }

    public function apply(Order $order): Money
    {
        $totalAmount = $order->getTotalAmount();
        if (!$totalAmount->greaterThanOrEqual($this->discount)) {
            throw new IneligibleCouponException(
                sprintf(
                    'Coupon discount value "%s" must be lower than total order amount value "%s".',
                    $this->discount->getCurrency()->getCode().' '.$this->discount->getAmount(),
                    $totalAmount->getCurrency()->getCode().' '.$totalAmount->getAmount(),
                ),
                $this
            );
        }

        return $totalAmount->subtract($this->discount);
    }
}
