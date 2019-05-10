<?php

namespace ESET\Shopping\Coupon;

abstract class AbstractCouponFactory implements CouponFactory
{
    private $codeGenerator;
    private $defaultCodeLength;

    public function __construct(UniqueCouponCodeGenerator $generator, int $defaultCodeLength = 8)
    {
        $this->codeGenerator = $generator;
        $this->defaultCodeLength = $defaultCodeLength;
    }

    public function createCoupon(array $options = []): Coupon
    {
        $code = $options['code'] ?? null;
        if (!$code) {
            $code = $this->codeGenerator->generate($options['length'] ?? $this->defaultCodeLength);
        }

        return $this->issueCoupon($code, $options);
    }

    abstract protected function issueCoupon(string $code, array $options = []): Coupon;
}
