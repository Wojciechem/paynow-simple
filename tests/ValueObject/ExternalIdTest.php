<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PaynowSimple\ValueObject\ExternalId
 */
class ExternalIdTest extends TestCase
{
    public function testCanCreateValidExternalId()
    {
        $id = new ExternalId('ACME-123456789-2020');

        $this->assertSame('ACME-123456789-2020', $id->id());
    }

    public function testCanNotCreateTooLongExternalId()
    {
        $this->expectException(InvalidArgument::class);

        new ExternalId('This is 51 characters, which is invalid! externalId');
    }
}
