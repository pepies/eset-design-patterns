<?php

namespace ESET\Shopping\Coupon;

class RandomCouponCodeGenerator implements UniqueCouponCodeGenerator
{
    public function generate(int $length): string
    {
        $hash = sha1(uniqid(random_int(0, \PHP_INT_MAX), true));

        return strtoupper($hash, 0, $length);
    }
}
