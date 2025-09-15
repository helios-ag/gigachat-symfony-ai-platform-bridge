<?php

declare(strict_types=1);

namespace FM\AI\Platform\Tests\Bridge\GigaChat\Files\Output;

use FM\AI\Platform\Bridge\GigaChat\Files\Output\FileItem;
use PHPUnit\Framework\TestCase;

final class FileItemTest extends TestCase
{
    public function testFromArrayAndToArrayWithAllFields(): void
    {
        $ts = 1_725_000_000; // arbitrary fixed timestamp

        $in = [
            'bytes'         => '1234',            // ensure cast to int
            'created_at'    => (string) $ts,      // ensure cast to int
            'filename'      => 'example.txt',
            'id'            => 'file_abc123',
            'object'        => 'file',
            'purpose'       => 'fine-tune',
            'access_policy' => 'private',
        ];

        $item = FileItem::fromArray($in);

        // Field assertions
        $this->assertSame(1234, $item->bytes);
        $this->assertInstanceOf(\DateTimeImmutable::class, $item->createdAt);
        $this->assertSame($ts, $item->createdAt->getTimestamp());
        $this->assertSame('example.txt', $item->filename);
        $this->assertSame('file_abc123', $item->id);
        $this->assertSame('file', $item->object);
        $this->assertSame('fine-tune', $item->purpose);
        $this->assertSame('private', $item->accessPolicy);

        // Round-trip
        $this->assertSame([
            'bytes'         => 1234,
            'created_at'    => $ts,
            'filename'      => 'example.txt',
            'id'            => 'file_abc123',
            'object'        => 'file',
            'purpose'       => 'fine-tune',
            'access_policy' => 'private',
        ], $item->toArray());
    }

    public function testFromArrayWithMissingFieldsUsesDefaults(): void
    {
        $item = FileItem::fromArray([]);

        // Defaults
        $this->assertSame(0, $item->bytes);
        $this->assertInstanceOf(\DateTimeImmutable::class, $item->createdAt);
        $this->assertSame(0, $item->createdAt->getTimestamp());
        $this->assertSame('', $item->filename);
        $this->assertSame('', $item->id);
        $this->assertSame('', $item->object);
        $this->assertSame('', $item->purpose);
        $this->assertSame('', $item->accessPolicy);

        $this->assertSame([
            'bytes'         => 0,
            'created_at'    => 0,
            'filename'      => '',
            'id'            => '',
            'object'        => '',
            'purpose'       => '',
            'access_policy' => '',
        ], $item->toArray());
    }
}
