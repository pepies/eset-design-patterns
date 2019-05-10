<?php

namespace ESET\Shopping\Coupon\Factory;

use ESET\Shopping\Coupon\Coupon;
use ESET\Shopping\Coupon\CouponBuilder;
use ESET\Shopping\Coupon\CouponFactory;

interface AbstractCouponFactory
{
    public function createCouponFactory(): CouponFactory;

    public function createCouponBuilder(array $options): CouponBuilder;

    public function createCoupon(array $options): Coupon;
}
