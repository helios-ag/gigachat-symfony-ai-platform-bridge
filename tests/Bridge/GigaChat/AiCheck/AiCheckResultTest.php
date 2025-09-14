<?php

declare(strict_types=1);

namespace FM\AI\Platform\Tests\Bridge\GigaChat\AiCheck;

use FM\AI\Platform\Bridge\GigaChat\AiCheck\AiCheckResult;
use PHPUnit\Framework\TestCase;

final class AiCheckResultTest extends TestCase
{
    public function testFromArrayCreatesExpectedObject(): void
    {
        $payload = [
            'category'     => 'likely_ai',
            'characters'   => 1234,
            'tokens'       => 256,
            'ai_intervals' => [[0, 10], [25, 40]],
        ];

        $result = AiCheckResult::fromArray($payload);

        $this->assertInstanceOf(AiCheckResult::class, $result);
        $this->assertSame('likely_ai', $result->category);
        $this->assertSame(1234, $result->characters);
        $this->assertSame(256, $result->tokens);
        $this->assertSame([[0, 10], [25, 40]], $result->aiIntervals);
    }

    public function testFromArrayAcceptsEmptyIntervals(): void
    {
        $payload = [
            'category'     => 'human',
            'characters'   => 0,
            'tokens'       => 0,
            'ai_intervals' => [],
        ];

        $result = AiCheckResult::fromArray($payload);

        $this->assertSame('human', $result->category);
        $this->assertSame(0, $result->characters);
        $this->assertSame(0, $result->tokens);
        $this->assertSame([], $result->aiIntervals);
    }
}
