<?php

namespace Tests\ESET\Shopping\Coupon;

use ESET\Shopping\Coupon\FixedCouponCodeGenerator;
use ESET\Shopping\Coupon\RateCoupon;
use ESET\Shopping\Coupon\RateCouponFactory;
use ESET\Shopping\Order;
use Money\Money;
use PHPUnit\Framework\TestCase;

final class RateCouponFactoryTest extends TestCase
{
    public function testGenerateCouponWithAutoGeneratedCode(): void
    {
        $factory = new RateCouponFactory(new FixedCouponCodeGenerator());
        $coupon = $factory->createCoupon(['percentage' => 15]);

        $this->assertInstanceOf(RateCoupon::class, $coupon);
        $this->assertSame('H4RY5N9B', $coupon->getCode());

        $discountedAmount = $coupon->apply(new Order(Money::EUR('10000')));

        $this->assertEquals(Money::EUR('8500'), $discountedAmount);
    }

    public function testGenerateCouponWithCustomCode(): void
    {
        $factory = new RateCouponFactory(new FixedCouponCodeGenerator());
        $coupon = $factory->createCoupon(['percentage' => 10, 'code' => 'ABCDEF99']);

        $this->assertInstanceOf(RateCoupon::class, $coupon);
        $this->assertSame('ABCDEF99', $coupon->getCode());

        $discountedAmount = $coupon->apply(new Order(Money::EUR('10000')));

        $this->assertEquals(Money::EUR('9000'), $discountedAmount);
    }
}