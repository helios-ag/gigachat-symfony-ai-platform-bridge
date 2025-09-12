<?php

namespace FM\AI\Platform\Bridge\GigaChat\Gpt\Output;

final class Usage
{
    public function __construct(
        public int    $promptTokens,
        public int    $completionTokens,
        public int    $precachedPromptTokens,
        public array  $totalTokens,
    )
    {
    }

    /**
     * @param array{prompt_tokens: int, completion_tokens: int, precached_prompt_tokens: int, total_tokens: int} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['prompt_tokens'],
            $data['completion_tokens'],
            $data['precached_prompt_tokens'],
            $data['total_tokens'],
        );
    }
}