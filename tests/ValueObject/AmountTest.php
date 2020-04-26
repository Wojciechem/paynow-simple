<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PaynowSimple\ValueObject\Amount
 */
class AmountTest extends TestCase
{
    public function testCanCreateValidAmount()
    {
        $amount = new Amount(15000);

        $this->assertSame(15000, $amount->amount());
    }

    public function testCanCreateGreatestPossibleAmount()
    {
        $amount = new Amount(9999999999);

        $this->assertSame(9999999999, $amount->amount());
    }

    public function testCanNotCreateZeroAmount()
    {
        $this->expectException(InvalidArgument::class);

        new Amount(0);
    }

    public function testCanNotCreateNegativeAmount()
    {
        $this->expectException(InvalidArgument::class);

        new Amount(-100);
    }

    public function testCanNotCreateTooLargeAmount()
    {
        $this->expectException(InvalidArgument::class);

        new Amount(10000000000);
    }
}
