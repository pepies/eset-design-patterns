<?php

namespace ESET\Shopping\Coupon;

use ESET\Shopping\Order;
use Money\Money;

interface Coupon
{
    public function getCode(): string;

    /**
     * @throws IneligibleCouponException When coupon cannot be applied
     */
    public function apply(Order $order): Money;
}
