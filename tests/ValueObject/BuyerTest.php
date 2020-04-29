<?php

namespace PaynowSimple\ValueObject;

use PHPUnit\Framework\TestCase;

class BuyerTest extends TestCase
{
    /**
     * @covers \PaynowSimple\ValueObject\Buyer
     *
     * @uses \PaynowSimple\ValueObject\Phone
     */
    public function testCanCreateElaborateBuyer()
    {
        $buyer = (new Buyer('buyer@cms.invalid'))
            ->addFirstName('John')
            ->addLastName('Doe')
            ->addPhone(new Phone('+48', '999999999'))
        ;

        $this->assertSame(
            [
                'email' => 'buyer@cms.invalid',
                'firstName' => 'John',
                'lastName' => 'Doe',
                'phone' => [
                    'prefix' => '+48',
                    'number' => 999999999,
                ],
            ],
            $buyer->jsonSerialize()
        );
    }
}
