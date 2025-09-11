<?php

namespace FM\AI\Platform\Bridge\GigaChat\Tokens;

final class TokensCountResult
{
    public function __construct(
        public string $object,
        public int    $tokens,
        public int    $characters,
    )
    {
    }

    /**
     * @param array{object: string, tokens: int, characters: int} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['object'],
            $data['tokens'],
            $data['characters'],
        );
    }
}