<?php

namespace PaynowSimple;

use PHPUnit\Framework\TestCase;

/**
 * @covers \PaynowSimple\Sha256SignatureCalculator
 */
class Sha256SignatureCalculatorTest extends TestCase
{
    public function testSignaturesAreEqualWithSameKeyAndData()
    {
        $calculator1 = new Sha256SignatureCalculator('abcdef');
        $calculator2 = new Sha256SignatureCalculator('abcdef');

        $this->assertSame(
            $calculator1->calculate(['value1' => 1, 'value2' => 2]),
            $calculator2->calculate(['value1' => 1, 'value2' => 2])
        );
    }

    public function testSignaturesAreNotEqualWithSameKeyAndDifferentData()
    {
        $calculator1 = new Sha256SignatureCalculator('abcdef');

        $this->assertNotSame(
            $calculator1->calculate(['value1' => 1, 'value2' => 2]),
            $calculator1->calculate(['value1' => 1, 'value2' => 3])
        );
    }

    public function testSignaturesAreNotEqualWithDifferentKeyAndSameData()
    {
        $calculator1 = new Sha256SignatureCalculator('abcdef');
        $calculator2 = new Sha256SignatureCalculator('defghi');

        $this->assertNotSame(
            $calculator1->calculate(['value1' => 1, 'value2' => 2]),
            $calculator2->calculate(['value1' => 1, 'value2' => 2])
        );
    }
}
