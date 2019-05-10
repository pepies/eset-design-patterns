<?php

namespace ESET\Shopping\Coupon;

use Assert\Assertion;

class RateCouponFactory extends AbstractCouponFactory
{
    protected function issueCoupon(string $code, array $options = []): Coupon
    {
        Assertion::notEmptyKey($options, 'percentage');

        return RateCoupon::fromPercentage($code, $options['percentage']);
    }
}
