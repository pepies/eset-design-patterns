<?php

namespace ESET\Shopping\Coupon;

use ESET\Shopping\Order;
use Money\Money;

class LimitedLifetimeConstraint extends CouponEligibilityConstraint
{
    private $validFrom;
    private $validUntil;

    public function __construct(Coupon $coupon, \DateTimeImmutable $from, \DateTimeImmutable $to)
    {
        parent::__construct($coupon);

        $this->validFrom = $from;
        $this->validUntil = $to;
    }

    public static function between(Coupon $coupon, string $from, string $to): self
    {
        return new self($coupon, new \DateTimeImmutable($from), new \DateTimeImmutable($to));
    }

    /**
     * @throws IneligibleCouponException When coupon cannot be applied
     */
    public function apply(Order $order): Money
    {
        $now = time();
        if ($now < $this->validFrom->getTimestamp()) {
            throw new IneligibleCouponException('Coupon is not yet eligible.', $this);
        }

        if ($now > $this->validUntil->getTimestamp()) {
            throw new IneligibleCouponException('Coupon is expired.', $this);
        }

        return $this->coupon->apply($order);
    }
}
