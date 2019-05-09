<?php

namespace ESET\Invoicing;

use Money\Money;

final class Invoice
{
    private $number;
    private $dueDate;
    private $dueAmount;
    private $customer;
    private $paid;

    public function __construct(
        string $number,
        \DateTimeImmutable $dueDate,
        Money $dueAmount,
        string $customer,
        bool $paid = false
    ) {
        $this->number = $number;
        $this->dueDate = $dueDate;
        $this->dueAmount = $dueAmount;
        $this->customer = $customer;
        $this->paid = $paid;
    }

    public function isOverdue(): bool
    {
        return !$this->paid && $this->dueDate->getTimestamp() < time();
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getDueDate(): \DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function getCurrency(): string
    {
        return $this->dueAmount->getCurrency()->getCode();
    }

    public function getTotalAmount(): string
    {
        return $this->getDueAmount()->getAmount();
    }

    public function getDueAmount(): Money
    {
        return $this->dueAmount;
    }

    public function getCustomer(): string
    {
        return $this->customer;
    }
}
