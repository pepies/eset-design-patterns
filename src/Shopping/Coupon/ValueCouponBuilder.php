<?php

namespace ESET\Shopping\Coupon;

class ValueCouponBuilder extends CouponBuilder
{
    private $factory;
    private $discount;

    public function __construct(CouponFactory $couponFactory)
    {
        $this->factory = $couponFactory;
    }

    public function withDiscount(string $discount)
    {
        $this->discount = $discount;

        return $this;
    }

    protected function initializeCoupon(): void
    {
        if ($this->coupon) {
            return;
        }

        if (!$this->discount) {
            throw new \LogicException('Discount value is required to build a value coupon.');
        }

        $options['discount'] = $this->discount;

        if ($this->customCode) {
            $options['code'] = $this->customCode;
        }

        $this->coupon = $this->factory->createCoupon($options);
    }
}
