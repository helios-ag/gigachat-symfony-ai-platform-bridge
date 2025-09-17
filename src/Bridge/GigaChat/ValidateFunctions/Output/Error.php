<?php

namespace FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\Output;

final class Error
{
    public function __construct(
        public string $description,
        public string $schemaLocation,
    )
    {
    }

    /**
     * @param array{description: string, schema_location: string} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['description'],
            $data['schema_location'],
        );
    }
}