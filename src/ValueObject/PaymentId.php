<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;

final class PaymentId
{
    private $id;

    public function __construct(string $id)
    {
        if (16 !== \mb_strlen($id)) {
            throw new InvalidArgument('Not a valid Paynow paymentId');
        }

        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
