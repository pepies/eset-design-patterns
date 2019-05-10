<?php

namespace ESET\Shopping\Coupon;

use Assert\Assertion;
use ESET\Shopping\MoneyParser;

class ValueCouponFactory extends AbstractCouponFactory
{
    private $parser;

    public function __construct(
        MoneyParser $moneyParser,
        UniqueCouponCodeGenerator $generator,
        int $defaultCodeLength = 8
    ) {
        parent::__construct($generator, $defaultCodeLength);

        $this->parser = $moneyParser;
    }

    protected function issueCoupon(string $code, array $options = []): Coupon
    {
        Assertion::notEmptyKey($options, 'discount');

        return new ValueCoupon($code, $this->parser->parse($options['discount']));
    }
}
