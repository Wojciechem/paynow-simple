<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PaynowSimple\ValueObject\Phone
 */
class PhoneTest extends TestCase
{
    public function testCanCreatePhone()
    {
        $phone = new Phone('+48', 100000000);

        $this->assertSame('+48', $phone->prefix());
        $this->assertSame(100000000, $phone->number());
    }

    public function testCanCreatePhoneWithLongPrefix()
    {
        $phone = new Phone('+4800', 100000000);

        $this->assertSame('+4800', $phone->prefix());
        $this->assertSame(100000000, $phone->number());
    }

    public function testCanNotCreatePhoneWithTooShortPrefix()
    {
        $this->expectException(InvalidArgument::class);

        $phone = new Phone('+4', 100000000);
    }

    public function testCanNotCreatePhoneWithTooLongPrefix()
    {
        $this->expectException(InvalidArgument::class);

        $phone = new Phone('+48000', 100000000);
    }

    public function testCanNotCreatePhoneWithNegativeNumber()
    {
        $this->expectException(InvalidArgument::class);

        $phone = new Phone('+48', -100000000);
    }

    public function testCanNotCreatePhoneWithZeroNumber()
    {
        $this->expectException(InvalidArgument::class);

        $phone = new Phone('+48', 0);
    }

    public function testCanNotCreatePhoneWithTooLargeNumber()
    {
        $this->expectException(InvalidArgument::class);

        $phone = new Phone('+48', 9999999991);
    }
}
