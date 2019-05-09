<?php

namespace ESET\Shopping\Coupon;

use Assert\Assertion;

class RateCouponFactory extends AbstractCouponFactory
{
    protected function issueCoupon(string $code, array $context): Coupon
    {
        Assertion::notEmptyKey($context, 'percentage');

        return RateCoupon::fromPercentage($code, $context['percentage']);
    }
}
