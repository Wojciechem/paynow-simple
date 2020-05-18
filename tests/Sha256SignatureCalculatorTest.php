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
        $this->assertSame(
            Sha256SignatureCalculator::calculate('abcdef', ['value1' => 1, 'value2' => 2]),
            Sha256SignatureCalculator::calculate('abcdef', ['value1' => 1, 'value2' => 2])
        );
    }

    public function testSignaturesAreNotEqualWithSameKeyAndDifferentData()
    {
        $this->assertNotSame(
            Sha256SignatureCalculator::calculate('abcdef', ['value1' => 1, 'value2' => 2]),
            Sha256SignatureCalculator::calculate('abcdef', ['value1' => 1, 'value2' => 3])
        );
    }

    public function testSignaturesAreNotEqualWithDifferentKeyAndSameData()
    {
        $this->assertNotSame(
            Sha256SignatureCalculator::calculate('abcdef', ['value1' => 1, 'value2' => 2]),
            Sha256SignatureCalculator::calculate('ghijkl', ['value1' => 1, 'value2' => 2])
        );
    }
}
