<?php
namespace Slack\Tests;

use InvalidArgumentException;
use Maknz\Slack\BlockElement;

class BlockElementUnitTest extends TestCase
{
    /**
     * @dataProvider factoryArrayProvider
     */
    public function testFactoryWithArray($type, $class)
    {
        $element = BlockElement::factory([
            'type' => $type,
        ]);

        $this->assertInstanceOf($class, $element);
    }

    public function factoryArrayProvider()
    {
        return [
            ['button',              BlockElement\Button::class],
            ['checkboxes',          BlockElement\Checkboxes::class],
            ['datepicker',          BlockElement\DatePicker::class],
            ['image',               BlockElement\Image::class],
            ['multi_static_select', BlockElement\MultiSelect::class],
            ['overflow',            BlockElement\Overflow::class],
            ['plain_text_input',    BlockElement\TextInput::class],
            ['radio_buttons',       BlockElement\RadioButtons::class],
            ['static_select',       BlockElement\Select::class],
        ];
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
