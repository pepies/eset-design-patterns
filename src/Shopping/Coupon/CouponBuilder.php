<?php

namespace ESET\Shopping\Coupon;

use Money\Currency;
use Money\Money;

class CouponBuilder
{
    private $coupon;

    private function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    public static function rate(float $percentage, string $code): self
    {
        return new self(RateCoupon::fromPercentage($code, $percentage));
    }

    public static function value(string $discount, string $code): self
    {
        return new self(new ValueCoupon($code, self::parseMoney($discount)));
    }

    private static function parseMoney(string $money): Money
    {
        [$currency, $amount] = explode(' ', $money);

        return new Money($amount, new Currency($currency));
    }

    public function expiresOn(string $expirationDate)
    {
        $this->coupon = new LimitedLifetimeConstraint(
            $this->coupon,
            \DateTimeImmutable::createFromFormat('U', time()),
            new \DateTimeImmutable($expirationDate)
        );

        return $this;
    }

    public function requiresMinimumPurchaseAmountOf(string $amount)
    {
        $this->coupon = new MinimumPurchaseAmountConstraint(
            $this->coupon,
            self::parseMoney($amount)
        );

        return $this;
    }

    public function getCoupon(): Coupon
    {
        return $this->coupon;
    }
}
