<?php

namespace FM\AI\Platform\Bridge\GigaChat\ValidateFunctions;

use FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\Output\Error;
use FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\Output\Warning;

final class ValidateFunctionsResult
{
    /** @var list<Error> */
    public array $errors;

    /** @var list<Warning> */
    public array $warnings;

    /**
     * @param int $status
     * @param string $message
     * @param string $jsonAiRulesVersion
     * @param list<Error> $errors
     * @param list<Warning> $warnings
     */
    public function __construct(
        public int $status,
        public string $message,
        public string $jsonAiRulesVersion,
        /** @param list<Error> $errors */
        array $errors,
        /** @param list<Warning> $warnings */
        array $warnings,
    )
    {
        $this->errors = $errors;
        $this->warnings = $warnings;
    }

    /**
     * @param array{
     *   status: int,
     *   message: string,
     *   json_ai_rules_version: string,
     *   errors?: list<array{description: string, schema_location: string}>,
     *   warnings?: list<array{description: string, schema_location: string}>
     * } $data
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