<?php

namespace ESET\Invoicing;

class LegacyInvoiceGenerator implements InvoiceGenerator
{
    public function generate(Invoice $invoice): string
    {
        $xmlTemplate = <<<EOF
<?xml version="1.0" encoding="utf-8"?>
<invoice number="{$invoice->getNumber()}">
    <customer>{$invoice->getCustomer()}</customer>
    <dueDate>{$invoice->getDueDate()->format('Y-m-d')}</dueDate>
    <dueAmount currency="{$invoice->getCurrency()}">
        {$invoice->getTotalAmount()}
    </dueAmount>
    %s
</invoice>

EOF;

        return sprintf(
            $xmlTemplate,
            $invoice->isOverdue() ? '<comment>Invoice is entitled to penalty fees</comment>' : ''
        );
    }
}
