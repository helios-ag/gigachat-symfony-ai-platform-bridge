<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat\AiCheck;

use FM\AI\Platform\Bridge\GigaChat\AiCheck;
use FM\AI\Platform\Bridge\GigaChat\AiCheck\ResultConverter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\AI\Platform\Result\RawHttpResult;
use Symfony\Contracts\HttpClient\ResponseInterface;

#[CoversClass(ResultConverter::class)]
#[Small]
#[UsesClass(AiCheck::class)]
final class ResultConverterTest extends TestCase
{
    public function testItConvertsAResponseToResult(): void
    {
        $result = $this->createStub(ResponseInterface::class);
        $result
            ->method('toArray')
            ->willReturn(json_decode($this->getAiStub(), true));

        $convertedResult = (new ResultConverter())->convert(new RawHttpResult($result));
        $convertedContent = $convertedResult->getContent();

        $this->assertInstanceOf(AiCheck\AiCheckResult::class, $convertedContent);
        $this->assertSame('mixed', $convertedContent->category);
    }

    private function getAiStub(): string
    {
        return <<<'JSON'
            {
              "category": "mixed",
              "characters": 500,
              "tokens": 38,
              "ai_intervals": [
                [
                  0,
                  100
                ],
                [
                  150,
                  200
                ]
              ]
            }
            JSON;
    }
}
