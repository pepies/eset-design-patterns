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

    public function createCoupon(array $context): Coupon
    {
        $code = $context['code'] ?? null;
        if (!$code) {
            $code = $this->codeGenerator->generate($context['length'] ?? $this->defaultCodeLength);
        }

        return $this->issueCoupon($code, $context);
    }

    abstract protected function issueCoupon(string $code, array $context): Coupon;
}
