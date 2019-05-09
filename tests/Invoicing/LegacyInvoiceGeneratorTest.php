<?php

namespace Tests\ESET\Invoicing;

use ESET\Invoicing\Invoice;
use ESET\Invoicing\LegacyInvoiceGenerator;
use Money\Money;
use PHPUnit\Framework\TestCase;

final class LegacyInvoiceGeneratorTest extends TestCase
{
    public function testGenerateInvoice(): void
    {
        $generator = new LegacyInvoiceGenerator();

        $this->assertStringEqualsFile(
            __DIR__.'/../Resources/fixtures/overdue-invoice.xml',
            $generator->generate(new Invoice(
                'ABC-1234-567',
                new \DateTimeImmutable('2019-03-30'),
                Money::EUR(12780),
                'McDonald'
            ))
        );
    }
}
