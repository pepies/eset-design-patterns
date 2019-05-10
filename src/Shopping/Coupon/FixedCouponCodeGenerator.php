<?php

namespace ESET\Shopping\Coupon;

final class FixedCouponCodeGenerator implements UniqueCouponCodeGenerator
{
    public function generate(int $length): string
    {
        return 'H4RY5N9B';
    }
}
