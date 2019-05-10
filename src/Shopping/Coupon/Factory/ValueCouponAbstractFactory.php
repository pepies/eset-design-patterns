<?php

namespace ESET\Shopping\Coupon\Factory;

use ESET\Shopping\Coupon\Coupon;
use ESET\Shopping\Coupon\CouponBuilder;
use ESET\Shopping\Coupon\CouponFactory;
use ESET\Shopping\Coupon\UniqueCouponCodeGenerator;
use ESET\Shopping\Coupon\ValueCouponBuilder;
use ESET\Shopping\Coupon\ValueCouponFactory;
use ESET\Shopping\MoneyParser;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValueCouponAbstractFactory implements AbstractCouponFactory
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
        return new ValueCouponFactory(
            new MoneyParser(),
            $this->couponCodeGenerator,
            $this->options['default_coupon_code_length']
        );
    }

    public function createCouponBuilder(array $options): CouponBuilder
    {
        $builder = new ValueCouponBuilder($this->createCouponFactory());
        $builder->withDiscount($options['discount']);

        return $builder;
    }

    public function createCoupon(array $options): Coupon
    {
        return $this->createCouponFactory()->createCoupon($options);
    }
}
