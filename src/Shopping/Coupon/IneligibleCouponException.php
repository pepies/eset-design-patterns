<?php

namespace ESET\Shopping\Coupon;

class IneligibleCouponException extends \RuntimeException
{
    private $coupon;

    public function __construct(string $message, Coupon $coupon, \Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);

        $this->coupon = $coupon;
    }

    public static function createIneligiblePeriodOfTime(Coupon $coupon, \Throwable $previous): self
    {
        return new self(
            sprintf('Coupon "%s" is supposed to be eligible between "foo" and "bar"', $coupon->getCode()),
            $coupon,
            $previous
        );
    }

    public function getCoupon(): Coupon
    {
        return $this->coupon;
    }
}
