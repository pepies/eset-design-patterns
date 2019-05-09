<?php

namespace ESET\Shopping\Coupon;

interface CouponFactory
{
    public function createCoupon(array $context): Coupon;
}
