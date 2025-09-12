<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat;

use FM\AI\Platform\Bridge\GigaChat\Embeddings;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[CoversClass(Embeddings::class)]
#[Small]
final class EmbeddingsTest extends TestCase
{
    public function testItCreatesEmbeddingsWithDefaultSettings(): void
    {
        $embeddings = new Embeddings();

        $this->assertSame(Embeddings::EMBEDDINGS, $embeddings->getName());
        $this->assertSame([], $embeddings->getOptions());
    }

    public function testItCreatesEmbeddingsWithCustomSettings(): void
    {
        $embeddings = new Embeddings(Embeddings::EMBEDDINGSGIGAR, ['dimensions' => 256]);

        $this->assertSame(Embeddings::EMBEDDINGSGIGAR, $embeddings->getName());
        $this->assertSame(['dimensions' => 256], $embeddings->getOptions());
    }

}