<?php

namespace ESET\Invoicing;

interface InvoiceGenerator
{
    public function generate(Invoice $invoice): string;
}
