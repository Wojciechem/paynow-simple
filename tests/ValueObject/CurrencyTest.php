<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PaynowSimple\ValueObject\Currency
 */
class CurrencyTest extends TestCase
{
    public function testCanCreateCurrency()
    {
        $currency = new Currency('PLN');

        $this->assertSame('PLN', $currency->currencyCode());
    }

    public function testCanNotCreateCurrencyWithTooShortCode()
    {
        $this->expectException(InvalidArgument::class);

        new Currency('BC');
    }

    public function testCanNotCreateCurrencyWithTooLongCode()
    {
        $this->expectException(InvalidArgument::class);

        new Currency('BITCOIN');
    }
}
