<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;

// TODO: rename to fix "lI" problem. Also, this ID is external to Paynow, not API consumer
class ExternalId
{
    private $id;

    public function __construct(string $id)
    {
        if (\mb_strlen($id) > 50) {
            throw new InvalidArgument('Payment externalId is too long, must be <= 50 characters');
        }

        $this->id = $id;
    }

    public function id(): string
    {
        return $this->id;
    }
}
