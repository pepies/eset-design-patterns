<?php

namespace ESET\Shopping\Coupon;

use ESET\Shopping\MoneyParser;

abstract class CouponBuilder
{
    /** @var Coupon */
    protected $coupon;
    protected $customCode;

    abstract protected function initializeCoupon(): void;

    final public function expiresOn(string $expirationDate)
    {
        $this->initializeCoupon();

        $this->coupon = new LimitedLifetimeConstraint(
            $this->coupon,
            \DateTimeImmutable::createFromFormat('U', time()),
            new \DateTimeImmutable($expirationDate)
        );

        return $this;
    }

    final public function withCustomCode(string $customCode)
    {
        $this->customCode = $customCode;

        return $this;
    }

    final public function requiresMinimumPurchaseAmountOf(string $amount)
    {
        $this->initializeCoupon();

        $this->coupon = new MinimumPurchaseAmountConstraint(
            $this->coupon,
            (new MoneyParser)->parse($amount)
        );

        return $this;
    }

    final public function getCoupon(): Coupon
    {
        return $this->coupon;
    }
}
