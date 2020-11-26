<?php
namespace Slack\Tests;

use InvalidArgumentException;
use Maknz\Slack\BlockElement;
use Maknz\Slack\BlockElement\Button;

class BlockElementUnitTest extends TestCase
{
    public function testFactoryWithArray()
    {
        $element = BlockElement::factory([
            'type' => 'button',
        ]);

        $this->assertInstanceOf(Button::class, $element);
    }

    public function testFactoryMissingType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot create BlockElement without a type attribute');
        $element = BlockElement::factory([]);
    }

    public function testFactoryInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid Block type "invalid"');
        $element = BlockElement::factory([
            'type' => 'invalid',
        ]);
    }

    public function testFactoryInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The attributes must be a Maknz\\Slack\\BlockElement or keyed array');
        $element = BlockElement::factory('Invalid');
    }

    public function testFactoryPassthrough()
    {
        $element = BlockElement::factory([
            'type' => 'button',
        ]);

        $this->assertSame($element, BlockElement::factory($element));
    }
}
