<?php

namespace PaynowSimple\ValueObject;

use PaynowSimple\Exception\InvalidArgument;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PaynowSimple\ValueObject\Description
 */
class DescriptionTest extends TestCase
{
    public function testCanCreateValidDescription()
    {
        $description = new Description($text = 'This is friendly, under-255-characters description');

        $this->assertSame($text, $description->description());
    }

    public function testCanNotCreateTooLongDescription()
    {
        $this->expectException(InvalidArgument::class);

        new Description(<<<'TEXT'
This is invalid message, which i promise is 256 characters long
This is invalid message, which i promise is 256 characters long
This is invalid message, which i promise is 256 characters long
This is invalid message, which i promise is 256 characters long.
TEXT
);
    }
}
