<?php

namespace ESET\Shopping\Coupon;

use ESET\Shopping\Order;
use Money\Money;

class MinimumPurchaseAmountConstraint extends CouponEligibilityConstraint
{
    private $minimumAmount;

    public function __construct(Coupon $coupon, Money $minimumAmount)
    {
        parent::__construct($coupon);

        $this->minimumAmount = $minimumAmount;
    }

    /**
     * @throws IneligibleCouponException When coupon cannot be applied
     */
    public function apply(Order $order): Money
    {
        if ($order->getTotalAmount()->lessThan($this->minimumAmount)) {
            throw new IneligibleCouponException('Minimum amount of purchase required.', $this);
        }

        return $this->coupon->apply($order);
    }
}
