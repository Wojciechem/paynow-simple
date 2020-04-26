<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PaynowSimple\ValueObject\PaymentId
 */
class PaymentIdTest extends TestCase
{
    public function testCanCreateValidPaymentId()
    {
        $paymentId = new PaymentId('TEST-AB1-2CD-EFG');

        $this->assertSame('TEST-AB1-2CD-EFG', $paymentId->id());
    }

    public function testCanNotCreateTooShortPaymentId()
    {
        $this->expectException(InvalidArgument::class);

        new PaymentId('ABC');
    }

    public function testCanNotCreateTooLongPaymentId()
    {
        $this->expectException(InvalidArgument::class);

        new PaymentId('17 little chars..');
    }
}
