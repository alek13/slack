<?php
namespace Slack\Tests\BlockElement;

use InvalidArgumentException;
use Maknz\Slack\BlockElement\Button;
use Maknz\Slack\BlockElement\Text;
use Slack\Tests\TestCase;

class ButtonUnitTest extends TestCase
{
    public function testButtonFromArray()
    {
        $b = new Button([
            'text'      => 'Button text',
            'action_id' => 'Button action',
            'value'     => 'button_value',
        ]);

        $this->assertSame(Text::TYPE_PLAIN, $b->getText()->getType());

        $this->assertSame('Button text', $b->getText()->getText());

        $this->assertSame('button_value', $b->getValue());
    }

    public function testInvalidConfirm()
    {
        $b = new Button([]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Confirm must be a keyed array or Maknz\\Slack\\Object\\Confirmation object');

        $b->setConfirm('Invalid');
    }

    public function testToArray()
    {
        $b = new Button([
            'text'      => 'Button text',
            'action_id' => 'Button action',
            'url'       => 'https://example.com',
            'value'     => 'button_value',
            'style'     => Button::STYLE_PRIMARY,
            'confirm'   => [
                'title'   => 'Confirmation title',
                'text'    => 'Confirmation text',
                'confirm' => 'Confirm',
                'deny'    => 'Deny',
            ],
        ]);

        $out = [
            'type' => 'button',
            'text' => [
                'type' => Text::TYPE_PLAIN,
                'text' => 'Button text',
                'emoji' => false,
            ],
            'action_id' => 'Button action',
            'url'       => 'https://example.com',
            'value'     => 'button_value',
            'style'     => Button::STYLE_PRIMARY,
            'confirm'   => [
                'title'   => [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Confirmation title',
                    'emoji' => false,
                ],
                'text'    => [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Confirmation text',
                    'emoji' => false,
                ],
                'confirm' => [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Confirm',
                    'emoji' => false,
                ],
                'deny'    => [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Deny',
                    'emoji' => false,
                ],
            ],
        ];

        $this->assertEquals($out, $b->toArray());
    }
}
