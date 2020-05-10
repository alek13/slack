<?php
namespace Slack\Tests\Block;

use InvalidArgumentException;
use Maknz\Slack\Block\Section;
use Maknz\Slack\BlockElement\Text;
use Slack\Tests\TestCase;
use UnexpectedValueException;

class SectionUnitTest extends TestCase
{
    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testSectionFromArray()
    {
        $text = new Text([
            'type' => Text::TYPE_PLAIN,
            'text' => 'Text',
        ]);

        $s = new Section([
            'text' => $text,
        ]);

        $this->assertEquals($text, $s->getText());

        $this->assertEquals([], $s->getFields());
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testSectionFromArrayWithTextArray()
    {
        $s = new Section([
            'text' => [
                'type' => Text::TYPE_MARKDOWN,
                'text' => 'Text',
            ],
        ]);

        $this->assertInstanceOf(Text::class, $s->getText());

        $this->assertEquals(Text::TYPE_MARKDOWN, $s->getText()->getType());

        $this->assertEquals('Text', $s->getText()->getText());
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testSectionFromArrayWithFields()
    {
        $s = new Section([
            'text' => 'Text',
            'fields' => [
                [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Text 1',
                ],
                [
                    'type' => Text::TYPE_MARKDOWN,
                    'text' => 'Text 2',
                ],
            ],
        ]);

        $fields = $s->getFields();

        $this->assertInstanceOf(Text::class, $fields[0]);

        $this->assertSame('Text 1', $fields[0]->getText());

        $this->assertSame('Text 2', $fields[1]->getText());
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testSetInvalidAccessory()
    {
        $s = new Section([
            'text' => 'Text',
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Block element Maknz\\Slack\\BlockElement\\Text is not valid for Maknz\\Slack\\Block\\Section');
        $s->setAccessory([
            'type' => Text::TYPE_PLAIN,
            'text' => 'Text',
        ]);
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testSectionToArray()
    {
        $in = [
            'text' => [
                'type' => Text::TYPE_MARKDOWN,
                'text' => 'Text',
            ],
            'block_id' => 'test_block',
            'fields' => [
                [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Text 1',
                ],
                [
                    'type' => Text::TYPE_MARKDOWN,
                    'text' => 'Text 1',
                ],
            ],
            'accessory' => [
                'type'      => 'button',
                'text'      => 'Button text',
                'action_id' => 'Button action',
                'value'     => 'button_value',
            ],
        ];

        // Adds a few default params
        $out = [
            'type' => 'section',
            'text' => [
                'type'     => Text::TYPE_MARKDOWN,
                'text'     => 'Text',
                'verbatim' => false,
            ],
            'block_id' => 'test_block',
            'fields' => [
                [
                    'type'     => Text::TYPE_PLAIN,
                    'text'     => 'Text 1',
                    'emoji'    => false,
                ],
                [
                    'type'     => Text::TYPE_MARKDOWN,
                    'text'     => 'Text 1',
                    'verbatim' => false,
                ],
            ],
            'accessory' => [
                'type' => 'button',
                'text' => [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Button text',
                    'emoji' => false,
                ],
                'action_id' => 'Button action',
                'value'     => 'button_value',
            ],
        ];

        $s = new Section($in);

        $this->assertEquals($out, $s->toArray());
    }

    /**
     * Text field becomes optional when fields are provided.
     *
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testSectionToArrayWithNoText()
    {
        $s = new Section([
            'fields' => [
                [
                    'type' => Text::TYPE_PLAIN,
                    'text' => 'Text 1',
                ],
                [
                    'type' => Text::TYPE_MARKDOWN,
                    'text' => 'Text 2',
                ],
            ],
        ]);

        $out = [
            'type'   => 'section',
            'fields' => [
                [
                    'type'     => Text::TYPE_PLAIN,
                    'text'     => 'Text 1',
                    'emoji'    => false,
                ],
                [
                    'type'     => Text::TYPE_MARKDOWN,
                    'text'     => 'Text 2',
                    'verbatim' => false,
                ],
            ],
        ];

        $this->assertEquals($out, $s->toArray());
    }

    /**
     * @throws \UnexpectedValueException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testSectionMissingText()
    {
        $s = new Section([]);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Section requires text attribute if no fields attribute is provided');
        $s->toArray();
    }
}
