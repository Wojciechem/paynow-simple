<?php

namespace PaynowSimple\ValueObject;

use PHPUnit\Framework\TestCase;

/**
 * @covers \PaynowSimple\ValueObject\Payment
 * @uses \PaynowSimple\ValueObject\Amount
 * @uses \PaynowSimple\ValueObject\Buyer
 * @uses \PaynowSimple\ValueObject\Currency
 * @uses \PaynowSimple\ValueObject\Description
 * @uses \PaynowSimple\ValueObject\ExternalId
 */
class PaymentTest extends TestCase
{
    public function testCanCreatePayment()
    {
        $payment = Payment::create(100, 'PLN', 'AE101', '...', 'test@box.invalid');

        $this->assertInstanceOf(Payment::class, $payment);
        $this->assertSame(
            [
                'amount' => 100,
                'currency' => 'PLN',
                'externalId' => 'AE101',
                'description' => '...',
                'buyer' => [
                    'email' => 'test@box.invalid'
                ]
            ],
            $payment->asArray()
        );

        $this->assertSame(
            [
                'amount' => 100,
                'currency' => 'PLN',
                'externalId' => 'AE101',
                'description' => '...',
                'buyer' => [
                    'email' => 'test@box.invalid'
                ]
            ],
            $payment->jsonSerialize()
        );

        $this->assertEquals(
            'AE101',
            $payment->externalId()->id()
        );
    }
}
