<?php

namespace FM\AI\Platform\Bridge\GigaChat\ValidateFunctions;

use FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\Output\Error;
use FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\Output\Warning;

final class ValidateFunctionsResult
{
    public function __construct(
        public int $status,
        public string $message,
        public string $jsonAiRulesVersion,
        public array  $errors,
        public array  $warnings,
    )
    {
    }

    /**
     * @param array{status: int, message: string, json_ai_rules_version: string, errors: array<Error>, warnings: array<Warning>} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['status'],
            $data['message'],
            $data['json_ai_rules_version'],
            array_map(fn (array $item) => Error::fromArray($item), $data['errors']),
            array_map(fn (array $item) => Warning::fromArray($item), $data['warnings']),
        );
    }
}