<?php

namespace FM\AI\Platform\Bridge\GigaChat\AiCheck;

final class AiCheckResult
{
    /**
     * @param list<list{int,int}> $aiIntervals
     */
    public function __construct(
        public string $category,
        public int    $characters,
        public int    $tokens,
        public array  $aiIntervals,
    )
    {
    }

    /**
     * @param array{
     *     category: string,
     *     characters: int,
     *     tokens: int,
     *     ai_intervals: list<list{int,int}>
     * } $data
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