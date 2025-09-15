<?php

declare(strict_types=1);

namespace FM\AI\Platform\Tests\Bridge\GigaChat\Files\Output;

use FM\AI\Platform\Bridge\GigaChat\Files\Output\FileItem;
use FM\AI\Platform\Bridge\GigaChat\Files\Output\FileList;
use PHPUnit\Framework\TestCase;

final class FileListTest extends TestCase
{
    public function testFromArrayWithValidData(): void
    {
        $ts = 1_725_000_000;

        $data = [
            'data' => [
                [
                    'bytes' => 123,
                    'created_at' => $ts,
                    'filename' => 'a.txt',
                    'id' => 'file1',
                    'object' => 'file',
                    'purpose' => 'upload',
                    'access_policy' => 'public',
                ],
                [
                    'bytes' => 456,
                    'created_at' => $ts + 1,
                    'filename' => 'b.txt',
                    'id' => 'file2',
                    'object' => 'file',
                    'purpose' => 'training',
                    'access_policy' => 'private',
                ],
            ],
        ];

        $list = FileList::fromArray($data);

        $this->assertCount(2, $list->data);
        $this->assertContainsOnlyInstancesOf(FileItem::class, $list->data);

        $this->assertSame('a.txt', $list->data[0]->filename);
        $this->assertSame('file2', $list->data[1]->id);
    }

    public function testFromArrayWithEmptyData(): void
    {
        $list = FileList::fromArray([]);

        $this->assertCount(0, $list->data);
    }

    public function testFromArraySkipsNonArrays(): void
    {
        $data = [
            'data' => [
                'not-an-array',
                123,
                null,
            ],
        ];

        $list = FileList::fromArray($data);

        $this->assertCount(0, $list->data);
    }
}
