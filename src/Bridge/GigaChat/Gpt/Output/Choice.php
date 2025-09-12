<?php

namespace FM\AI\Platform\Bridge\GigaChat\Gpt\Output;

final class Choice
{
    public function __construct(
        public string $category,
        public int    $characters,
        public int    $tokens,
        public array  $aiIntervals,
    )
    {
    }

    /**
     * @param array{category: string, characters: int, tokens: int, ai_intervals: array<array<int>} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['category'],
            $data['characters'],
            $data['tokens'],
            $data['ai_intervals'],
        );
    }
}