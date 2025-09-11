<?php

namespace FM\AI\Platform\Bridge\GigaChat;

use Symfony\AI\Platform\Model;

class Embeddings extends Model
{
    public const EMBEDDINGS = 'Embeddings';
    public const EMBEDDINGSGIGAR = 'EmbeddingsGigaR';

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(string $name = self::EMBEDDINGS, array $options = [])
    {
        parent::__construct($name, [], $options);
    }
}