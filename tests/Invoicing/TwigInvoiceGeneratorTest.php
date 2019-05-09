<?php

namespace Tests\ESET\Invoicing;

use ESET\Invoicing\Invoice;
use ESET\Invoicing\TwigInvoiceGenerator;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class TwigInvoiceGeneratorTest extends TestCase
{
    public function testGenerateInvoice(): void
    {
        $generator = new TwigInvoiceGenerator(new Environment(new FilesystemLoader(__DIR__.'/../../templates')));

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
