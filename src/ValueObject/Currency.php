<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;

class Currency
{
    private $currencyCode;

    public function __construct(string $currencyCode)
    {
        if (3 !== \mb_strlen($currencyCode)) {
            throw new InvalidArgument('Please provide valid ISO-4217 currency code');
        }

        $this->currencyCode = $currencyCode;
    }

    public function currencyCode(): string
    {
        return $this->currencyCode;
    }
}
