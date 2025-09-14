<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat\Files;

use FM\AI\Platform\Bridge\GigaChat\Files\Output\FileList;
use FM\AI\Platform\Bridge\GigaChat\Files\ResultConverter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Symfony\AI\Platform\Result\ObjectResult;
use Symfony\AI\Platform\Result\RawResultInterface;

#[CoversClass(ResultConverter::class)]
#[Small]
final class ResultConverterTest extends TestCase
{
    public function testItConvertsAResponseToAFilesResponse(): void
    {
        $converter = new ResultConverter();

        $rawResult = $this->createMock(RawResultInterface::class);
        $rawResult->method('getData')->willReturn(json_decode($this->getFilesStub(), true));;

        $convertedResult = $converter->convert($rawResult);

        $this->assertInstanceOf(ObjectResult::class, $convertedResult);
        $data = $convertedResult->getContent();
        $this->assertInstanceOf(FileList::class, $data);
        $this->assertEquals('file123', $data->data[0]->filename);
    }

    private function getFilesStub(): string
    {
        return <<<'JSON'
            {
              "data": [
                {
                  "bytes": 120000,
                  "created_at": 1677610602,
                  "filename": "file123",
                  "id": "6f0b1291-c7f3-43c6-bb2e-9f3efb2dc98e",
                  "object": "file",
                  "purpose": "general",
                  "access_policy": "private"
                }
              ]
            }
            JSON;
    }
}
