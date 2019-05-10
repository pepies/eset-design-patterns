<?php

namespace Tests\ESET\Shopping\Coupon;

use ESET\Shopping\Coupon\CouponBuilder;
use ESET\Shopping\Coupon\Factory\RateCouponAbstractFactory;
use ESET\Shopping\Coupon\FixedCouponCodeGenerator;
use ESET\Shopping\Coupon\IneligibleCouponException;
use ESET\Shopping\Coupon\LimitedLifetimeConstraint;
use ESET\Shopping\Coupon\RateCoupon;
use ESET\Shopping\Order;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\PhpUnit\ClockMock;

final class LimitedLifetimeConstraintTest extends TestCase
{
    private $factory;

    protected function setUp(): void
    {
        $this->factory = new RateCouponAbstractFactory(new FixedCouponCodeGenerator());
    }

    public function testCouponIsEligible(): void
    {
        ClockMock::register(LimitedLifetimeConstraint::class);
        ClockMock::register(CouponBuilder::class);
        ClockMock::withClockMock(strtotime('2019-01-16 08:34:51'));

        $builder = $this->factory->createCouponBuilder(['percentage' => 15]);

        $coupon = $builder
            ->withCustomCode('dehfgwre')
            ->requiresMinimumPurchaseAmountOf('EUR 4000')
            ->expiresOn('2019-01-31 23:59:59')
            ->getCoupon()
        ;

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
