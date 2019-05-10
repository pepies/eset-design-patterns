<?php

namespace ESET\Shopping;

use Money\Currency;
use Money\Money;

final class MoneyParser
{
    public function parse(string $money): Money
    {
        [$currency, $amount] = explode(' ', $money);

        return new Money($amount, new Currency($currency));
    }
}
