<?php


namespace ESET\Invoicing;

class InvoiceService
{
    private $generator;

    public function __construct(InvoiceGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function generateInvoice(Invoice $invoice, string $savePath): void
    {
        $xml = $this->generator->generate($invoice);

        file_put_contents($savePath.'/'.$invoice->getNumber().'.xml', $xml);
    }
}
