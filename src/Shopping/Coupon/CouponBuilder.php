<?php

namespace ESET\Shopping\Coupon;

use ESET\Shopping\MoneyParser;

abstract class CouponBuilder
{
    /** @var Coupon */
    protected $coupon;
    protected $customCode;

    abstract protected function initializeCoupon(): void;

    public function expiresOn(string $expirationDate)
    {
        $this->initializeCoupon();

        $this->coupon = new LimitedLifetimeConstraint(
            $this->coupon,
            \DateTimeImmutable::createFromFormat('U', time()),
            new \DateTimeImmutable($expirationDate)
        );

        return $this;
    }

    public function withCustomCode(string $customCode)
    {
        $this->customCode = $customCode;

        return $this;
    }

    public function requiresMinimumPurchaseAmountOf(string $amount)
    {
        $this->initializeCoupon();

        $this->coupon = new MinimumPurchaseAmountConstraint(
            $this->coupon,
            (new MoneyParser)->parse($amount)
        );

        return $this;
    }

    public function getCoupon(): Coupon
    {
        return $this->coupon;
    }
}
