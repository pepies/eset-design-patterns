<?php

namespace ESET\Shopping\Coupon;

class RateCouponBuilder extends CouponBuilder
{
    private $factory;
    private $percentage;

    public function __construct(CouponFactory $couponFactory)
    {
        $this->factory = $couponFactory;
    }

    public function withPercentage(float $percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    protected function initializeCoupon(): void
    {
        if ($this->coupon) {
            return;
        }

        if (!$this->percentage) {
            throw new \LogicException('Discount percentage is required to build a rate coupon.');
        }

        $options['percentage'] = $this->percentage;

        if ($this->customCode) {
            $options['code'] = $this->customCode;
        }

        $this->coupon = $this->factory->createCoupon($options);
    }
}
