<?php

namespace FM\AI\Platform\Bridge\GigaChat\Gpt;

use FM\AI\Platform\Bridge\GigaChat\Gpt\Output\Choice;
use FM\AI\Platform\Bridge\GigaChat\Gpt\Output\Usage;

final class GptResult
{
    public function __construct(
        public array $choices,
        public int   $created,
        public string $model,
        public object $usage,
        public string $object,
    )
    {
    }

    /**
     * @param array{choices: object[], created: int, model: string, usage: object, object: string} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            array_map(fn (array $item) => Choice::fromArray($item), $data['choices']),
            $data['created'],
            $data['model'],
            Usage::fromArray($data['usage']),
            $data['object'],
        );
    }
}