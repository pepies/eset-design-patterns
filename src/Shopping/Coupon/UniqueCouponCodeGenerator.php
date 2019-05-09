<?php

namespace ESET\Shopping\Coupon;

interface UniqueCouponCodeGenerator
{
    public function generate(int $length): string;
}
