<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat\Embeddings;

use FM\AI\Platform\Bridge\GigaChat\Embeddings;
use FM\AI\Platform\Bridge\GigaChat\Embeddings\ResultConverter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\AI\Platform\Result\RawHttpResult;
use Symfony\AI\Platform\Result\VectorResult;
use Symfony\AI\Platform\Vector\Vector;
use Symfony\Contracts\HttpClient\ResponseInterface;

#[CoversClass(ResultConverter::class)]
#[Small]
#[UsesClass(Vector::class)]
#[UsesClass(VectorResult::class)]
#[UsesClass(Embeddings::class)]
final class ResultConverterTest extends TestCase
{
    public function testItConvertsAResponseToAVectorResult(): void
    {
        $result = $this->createStub(ResponseInterface::class);
        $result
            ->method('toArray')
            ->willReturn(json_decode($this->getEmbeddingStub(), true));

        $vectorResult = (new ResultConverter())->convert(new RawHttpResult($result));
        $convertedContent = $vectorResult->getContent();

        $this->assertCount(1, $convertedContent);

        $this->assertSame([0], $convertedContent[0]->getData());
    }

    private function getEmbeddingStub(): string
    {
        return <<<'JSON'
            {
              "object": "list",
              "data": [
                {
                  "object": "embedding",
                  "embedding": [
                    0
                  ],
                  "index": 0,
                  "usage": {
                    "prompt_tokens": 6
                  }
                }
              ],
              "model": "Embeddings"
            }
            JSON;
    }
}
