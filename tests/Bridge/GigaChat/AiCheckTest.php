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
        $embeddings = new Embeddings();

        $this->assertSame(AiCheck::GIGACHECKCLASSIFICATION, $embeddings->getName());
        $this->assertSame([], $embeddings->getOptions());
    }

    public function testItCreatesAiCheckWithCustomSettings(): void
    {
        $embeddings = new Embeddings(AiCheck::GIGACHECKDETECTION, ['dimensions' => 256]);

        $this->assertSame(Embeddings::EMBEDDINGSGIGAR, $embeddings->getName());
        $this->assertSame(['dimensions' => 256], $embeddings->getOptions());
    }

}