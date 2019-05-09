<?php

namespace Tests\ESET\Shopping\Coupon;

use ESET\Shopping\Coupon\IneligibleCouponException;
use ESET\Shopping\Coupon\LimitedLifetimeConstraint;
use ESET\Shopping\Coupon\MinimumPurchaseAmountConstraint;
use ESET\Shopping\Coupon\RateCoupon;
use ESET\Shopping\Order;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\ClockMock;

final class LimitedLifetimeConstraintTest extends TestCase
{
    public function testCouponIsEligible(): void
    {
        ClockMock::register(LimitedLifetimeConstraint::class);
        ClockMock::withClockMock(strtotime('2019-01-16 08:34:51'));

        $coupon = LimitedLifetimeConstraint::between(
            new MinimumPurchaseAmountConstraint(
                RateCoupon::fromPercentage('dehfgwre', 15),
                Money::EUR(4000)
            ),
            '2019-01-01 00:00:00',
            '2019-01-31 23:59:59',
        );

        $order = new Order(Money::EUR(12500));

        $this->assertEquals(Money::EUR(10625), $coupon->apply($order));
    }

    public function testCouponIsNotEligible(): void
    {
        ClockMock::register(LimitedLifetimeConstraint::class);
        ClockMock::withClockMock(strtotime('2019-02-01 00:00:00'));

        $coupon = LimitedLifetimeConstraint::between(
            RateCoupon::fromPercentage('dehfgwre', 15),
            '2019-01-01 00:00:00',
            '2019-01-31 23:59:59',
        );

        $order = new Order(Money::EUR(12500));

        $this->expectException(IneligibleCouponException::class);
        $this->expectExceptionMessage('Coupon is expired.');

        $coupon->apply($order);
    }
}
