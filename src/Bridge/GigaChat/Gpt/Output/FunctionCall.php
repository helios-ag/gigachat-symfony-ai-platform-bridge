<?php

namespace FM\AI\Platform\Bridge\GigaChat\Gpt\Output;

final class FunctionCall
{
    public function __construct(
        public string $name,
        public string    $arguments,
    )
    {
    }

    /**
     * @param array{name: string, arguments: string} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['arguments'],
        );
    }
}