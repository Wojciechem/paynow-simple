<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;

class Phone
{
    private $prefix;
    private $number;

    public function __construct(string $prefix, int $number)
    {
        if (1 !== \preg_match('/^\+([0-9]){2,4}$/', $prefix)) {
            throw new InvalidArgument('Invalid phone prefix');
        }

        if ($number < 1) {
            throw new InvalidArgument('Phone Number must be > 0');
        }

        if ($number > 999999999) {
            throw new InvalidArgument('Phone Number must be <= 9 characters');
        }

        $this->prefix = $prefix;
        $this->number = $number;
    }

    public function prefix(): string
    {
        return $this->prefix;
    }

    public function number(): int
    {
        return $this->number;
    }
}