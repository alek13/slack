<?php
namespace Slack\Tests\Object;

use Maknz\Slack\BlockElement\Text;
use Maknz\Slack\Object\Option;
use Slack\Tests\TestCase;

class OptionUnitTest extends TestCase
{
    public function testOptionFromArray()
    {
        $o = new Option([
            'text'        => 'Option 1',
            'value'       => 'option_1',
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $o->getText()->getType());

        $this->assertSame('Option 1', $o->getText()->getText());
    }

    public function testOptionIsSelected()
    {
        $o = new Option([
            'text'     => 'Option 1',
            'value'    => 'option_1',
            'selected' => true,
        ]);

        $this->assertTrue($o->isInitiallySelected());
    }

    public function testToArray()
    {
        $o = new Option([
            'text'     => 'Option 1',
            'value'    => 'option_1',
            'selected' => true,
        ]);

        $out = [
            'text' => [
                'type' => Text::TYPE_PLAIN,
                'text'  => 'Option 1',
                'emoji' => false,
            ],
            'value' => 'option_1',
        ];

        $this->assertEquals($out, $o->toArray());
    }

    public function testToArrayWithDescription()
    {
        $o = new Option([
            'text'        => 'Option 1',
            'value'       => 'option_1',
            'description' => 'Option description',
        ]);

        $out = [
            'text' => [
                'type' => Text::TYPE_PLAIN,
                'text'  => 'Option 1',
                'emoji' => false,
            ],
            'value' => 'option_1',
            'description' => [
                'type' => Text::TYPE_PLAIN,
                'text'  => 'Option description',
                'emoji' => false,
            ],
        ];

        $this->assertEquals($out, $o->toArray());
    }

    public function testToArrayWithUrl()
    {
        $o = new Option([
            'text'  => 'Option 1',
            'value' => 'option_1',
            'url'   => 'http://fake.host/',
        ]);

        $out = [
            'text' => [
                'type' => Text::TYPE_PLAIN,
                'text'  => 'Option 1',
                'emoji' => false,
            ],
            'value' => 'option_1',
            'url' => 'http://fake.host/',
        ];

        $this->assertEquals($out, $o->toArray());
    }
}
