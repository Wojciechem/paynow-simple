<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;

class PaymentId
{
    private $id;

    public function __construct(string $id)
    {
        if (\mb_strlen($id) !== 16) {
            throw new InvalidArgument('Not a valid Paynow paymentId');
        }

        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}