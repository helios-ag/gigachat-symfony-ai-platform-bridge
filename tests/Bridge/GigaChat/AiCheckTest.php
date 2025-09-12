<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat;

use FM\AI\Platform\Bridge\GigaChat\AiCheck;
use FM\AI\Platform\Bridge\GigaChat\Embeddings;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[CoversClass(AiCheck::class)]
#[Small]
final class AiCheckTest extends TestCase
{
    public function testItCreatesAiCheckWithDefaultSettings(): void
    {
        $aicheck = new AiCheck();

        $this->assertSame(AiCheck::GIGACHECKCLASSIFICATION, $aicheck->getName());
        $this->assertSame([], $aicheck->getOptions());
    }

    public function testItCreatesAiCheckWithCustomSettings(): void
    {
        $aicheck = new AiCheck(AiCheck::GIGACHECKDETECTION, ['dimensions' => 256]);

        $this->assertSame(Embeddings::EMBEDDINGSGIGAR, $aicheck->getName());
        $this->assertSame(['dimensions' => 256], $aicheck->getOptions());
    }

}