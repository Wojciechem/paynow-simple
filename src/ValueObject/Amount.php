<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;

class Amount
{
    private $amount;

    public function __construct(int $amount)
    {
        if ($amount < 1) {
            throw new InvalidArgument('Amount must be > 0.');
        }

        if ($amount > 9999999999) {
            throw new InvalidArgument('Amount must be <= 10 characters.');
        }

        $this->amount = $amount;
    }

    public function amount(): int
    {
        return $this->amount;
    }
}
