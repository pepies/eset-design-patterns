<?php

namespace Tests\ESET\Shopping\Coupon;

use ESET\Shopping\Coupon\IneligibleCouponException;
use ESET\Shopping\Coupon\MinimumPurchaseAmountConstraint;
use ESET\Shopping\Coupon\ValueCoupon;
use ESET\Shopping\Order;
use Money\Money;
use PHPUnit\Framework\TestCase;

class MinimumPurchaseAmountConstraintTest extends TestCase
{
    public function testCouponIsEligibleForDiscount(): void
    {
        $coupon = new MinimumPurchaseAmountConstraint(
            new ValueCoupon('fgewgfkwegf', Money::EUR(2000)),
            Money::EUR(6000)
        );

        $order = new Order(Money::EUR(7900));

        $this->assertEquals(Money::EUR(5900), $coupon->apply($order));
    }

    public function testCouponIsNotEligibleForDiscount(): void
    {
        $coupon = new MinimumPurchaseAmountConstraint(
            new ValueCoupon('fgewgfkwegf', Money::EUR(2000)),
            Money::EUR(6000)
        );

        $this->expectException(IneligibleCouponException::class);

        $coupon->apply(new Order(Money::EUR(5999)));
    }
}
