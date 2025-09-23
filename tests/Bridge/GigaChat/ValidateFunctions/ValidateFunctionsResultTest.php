<?php

declare(strict_types=1);
namespace FM\AI\Platform\Tests\Bridge\GigaChat\ValidateFunctions;

use FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\Output\Error;
use FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\Output\Warning;
use FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\ValidateFunctionsResult;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ValidateFunctionsResult::class)]
final class ValidateFunctionsResultTest extends TestCase
{
    public function testFromArrayHydratesAllFields(): void
    {
        $input = [
            'status' => 200,
            'message' => 'OK',
            'json_ai_rules_version' => '1.2.3',
            // shape for items depends on your Error/Warning DTOs; keep minimal but realistic
            'errors' => [
                ['schema_location' => 'E001', 'description' => 'Invalid function signature'],
                ['schema_location' => 'E002', 'description' => 'Unknown parameter'],
            ],
            'warnings' => [
                ['schema_location' => 'W001', 'description' => 'Deprecated field'],
            ],
        ];

        $result = ValidateFunctionsResult::fromArray($input);

        // Scalars
        self::assertSame(200, $result->status);
        self::assertSame('OK', $result->message);
        self::assertSame('1.2.3', $result->jsonAiRulesVersion);

        // Collections: sizes
        self::assertCount(2, $result->errors);
        self::assertCount(1, $result->warnings);

        // Collections: types
        foreach ($result->errors as $err) {
            self::assertInstanceOf(Error::class, $err);
        }
        foreach ($result->warnings as $warn) {
            self::assertInstanceOf(Warning::class, $warn);
        }
    }

    public function testFromArrayHandlesEmptyLists(): void
    {
        $input = [
            'status' => 422,
            'message' => 'Unprocessable',
            'json_ai_rules_version' => '2.0.0',
            'errors' => [],
            'warnings' => [],
        ];

        $result = ValidateFunctionsResult::fromArray($input);

        self::assertSame(422, $result->status);
        self::assertSame('Unprocessable', $result->message);
        self::assertSame('2.0.0', $result->jsonAiRulesVersion);
        self::assertSame([], $result->errors);
        self::assertSame([], $result->warnings);
    }
}
