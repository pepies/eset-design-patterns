<?php

namespace ESET\Shopping\Coupon;

use Assert\Assertion;
use Money\Currency;
use Money\Money;

class ValueCouponFactory extends AbstractCouponFactory
{
    private function parseMoney(string $money): Money
    {
        [$currency, $amount] = explode(' ', $money);

        return new Money($amount, new Currency($currency));
    }

    protected function issueCoupon(string $code, array $context): Coupon
    {
        Assertion::notEmptyKey($context, 'discount');

        return new ValueCoupon($code, $this->parseMoney($context['discount']));
    }
}
