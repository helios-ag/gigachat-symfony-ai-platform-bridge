<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat\BatchRequest;

use FM\AI\Platform\Bridge\GigaChat\BatchRequest\BatchResult;
use FM\AI\Platform\Bridge\GigaChat\BatchRequest\ResultConverter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\AI\Platform\Result\RawHttpResult;
use Symfony\Contracts\HttpClient\ResponseInterface;

#[CoversClass(ResultConverter::class)]
#[Small]
#[UsesClass(BatchResult::class)]
final class ResultConverterTest extends TestCase
{
    public function testItConvertsAResponseToResult(): void
    {
        $result = $this->createStub(ResponseInterface::class);
        $result
            ->method('toArray')
            ->willReturn(json_decode($this->getBatchStub(), true));

        $convertedResult = (new ResultConverter())->convert(new RawHttpResult($result));
        $convertedContent = $convertedResult->getContent();

        $this->assertInstanceOf(BatchResult::class, $convertedContent);
        $this->assertSame('chat_completions', $convertedContent->method);
    }

    private function getBatchStub(): string
    {
        return <<<'JSON'
            {
              "id": "string",
              "method": "chat_completions",
              "request_counts": [
                { "total": 42 },
                { "total": 17 },
                { "total": 99 }
              ],
              "status": "created",
              "created_at": 0,
              "updated_at": 0
            }
            JSON;
    }
}
