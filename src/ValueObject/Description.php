<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;

final class Description
{
    /** @var string */
    private $description;

    public function __construct(string $description)
    {
        if (\mb_strlen($description) > 255) {
            throw new InvalidArgument('Description must be <= 255 characters');
        }

        $this->description = $description;
    }

    public function description(): string
    {
        return $this->description;
    }
}
