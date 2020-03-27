<?php
namespace Slack\Tests\Block;

use Maknz\Slack\Block\File;
use Slack\Tests\TestCase;

class FileUnitTest extends TestCase
{
    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testFileFromArray()
    {
        $f = new File([
            'external_id' => 'ABC123',
            'source'      => 'remote',
        ]);

        $this->assertSame('ABC123', $f->getExternalId());
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testFileToArray()
    {
        $f = new File([
            'external_id' => 'ABC123',
        ]);

        $out = [
            'type' => 'file',
            'external_id' => 'ABC123',
            'source' => 'remote',
        ];

        $this->assertEquals($out, $f->toArray());
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public function testFileToArrayWithBlock()
    {
        $f = new File([
            'external_id' => 'ABC123',
            'block_id'    => 'block-1234',
        ]);

        $out = [
            'type' => 'file',
            'external_id' => 'ABC123',
            'source' => 'remote',
            'block_id' => 'block-1234',
        ];

        $this->assertEquals($out, $f->toArray());
    }
}
