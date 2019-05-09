<?php

namespace ESET\Shopping\Coupon;

abstract class CouponEligibilityConstraint implements Coupon
{
    protected $coupon;

    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public function getCode(): string
    {
        return $this->coupon->getCode();
    }
}
