<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat\ValidateFunctions;

use FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\ResultConverter;
use FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\ValidateFunctionsResult;
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
        $this->assertInstanceOf(ValidateFunctionsResult::class, $data);
        $this->assertEquals('Function is valid', $data->message);
    }

    private function getFilesStub(): string
    {
        return <<<'JSON'
            {
              "status": 200,
              "message": "Function is valid",
              "json_ai_rules_version": "1.0.5",
              "errors": [
                {
                  "description": "name is required",
                  "schema_location": "(root)"
                }
              ],
              "warnings": [
                {
                  "description": "few_shot_examples are missing",
                  "schema_location": "(root)"
                }
              ]
            }
            JSON;
    }
}
