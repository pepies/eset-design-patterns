<?php

namespace ESET\Invoicing;

use Twig\Environment;

class TwigInvoiceGenerator implements InvoiceGenerator
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function generate(Invoice $invoice): string
    {
        return $this->twig->render('invoice.xml.twig', [
            'invoice' => $invoice,
        ]);
    }
}
