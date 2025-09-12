<?php

namespace FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\Output;

final class Warning
{
    public function __construct(
        public string $description,
        public string $schemaLocation,
    )
    {
    }

    /**
     * @param array{description: string, schemaLocation: string} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['description'],
            $data['schemaLocation'],
        );
    }
}