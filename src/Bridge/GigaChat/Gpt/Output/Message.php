<?php

namespace FM\AI\Platform\Bridge\GigaChat\Gpt\Output;

final class Message
{
    public function __construct(
        public string $role,
        public string $content,
        public int    $created,
        public string $name,
        public string $functionsStateId,
        public array  $functionCall,
    )
    {
    }

    /**
     * @param array{
     *     role: string,
     *     content: string,
     *     created: int,
     *     name: string,
     *     functionsStateId: string,
     *     functionCall: object,
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['role'],
            $data['content'],
            $data['created'],
            $data['name'],
            $data['functionsStateId'],
            $data['functionCall'],
        );
    }
}