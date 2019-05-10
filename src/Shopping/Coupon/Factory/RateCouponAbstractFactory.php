<?php

namespace ESET\Shopping\Coupon\Factory;

use ESET\Shopping\Coupon\Coupon;
use ESET\Shopping\Coupon\CouponBuilder;
use ESET\Shopping\Coupon\CouponFactory;
use ESET\Shopping\Coupon\RateCouponBuilder;
use ESET\Shopping\Coupon\RateCouponFactory;
use ESET\Shopping\Coupon\UniqueCouponCodeGenerator;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RateCouponAbstractFactory implements AbstractCouponFactory
{
    private $couponCodeGenerator;
    private $options;

    public function __construct(
        UniqueCouponCodeGenerator $couponCodeGenerator,
        array $options = []
    ) {
        $this->couponCodeGenerator = $couponCodeGenerator;

        $optionsResolver = new OptionsResolver();
        $this->configureOptions($optionsResolver);

        $this->options = $optionsResolver->resolve($options);
    }

    private function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'default_coupon_code_length' => 8,
        ]);

        $resolver->setAllowedTypes('default_coupon_code_length', 'int');
        $resolver->setAllowedValues('default_coupon_code_length', range(6, 20));
    }

    public function createCouponFactory(): CouponFactory
    {
        return new RateCouponFactory(
            $this->couponCodeGenerator,
            $this->options['default_coupon_code_length']
        );
    }

    public function createCouponBuilder(array $options): CouponBuilder
    {
        $buider = new RateCouponBuilder($this->createCouponFactory());
        $buider->withPercentage($options['percentage']);

        return $buider;
    }

    public function createCoupon(array $options): Coupon
    {
        return $this->createCouponFactory()->createCoupon($options);
    }
}
