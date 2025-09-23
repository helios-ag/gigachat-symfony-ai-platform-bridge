<?php

declare(strict_types=1);

namespace FM\AI\Platform\Bridge\GigaChat\Gpt\Output;

use Webmozart\Assert\Assert;

final readonly class Message
{
    public function __construct(
        public string $role,
        public string $content,
        public int $created,
        public ?string $name = null,
        public ?string $functionsStateId = null,
        public ?FunctionCall $functionCall = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @throws \InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'role');
        Assert::keyExists($data, 'content');
        Assert::keyExists($data, 'created');

        Assert::string($data['role']);
        Assert::string($data['content']);
        Assert::integer($data['created']);

        $name = null;
        if (array_key_exists('name', $data)) {
            Assert::nullOrString($data['name']);
            $name = $data['name'];
        }

        $functionsStateId = null;
        if (array_key_exists('functions_state_id', $data)) {
            Assert::nullOrString($data['functions_state_id']);
            $functionsStateId = $data['functions_state_id'];
        }

        $functionCall = null;
        if (array_key_exists('function_call', $data) && $data['function_call'] !== null) {
            Assert::isArray($data['function_call']);
            /** @var array<string, mixed> $raw */
            $raw = $data['function_call'];
            $functionCall = FunctionCall::fromArray($raw);
        }

        return new self(
            $data['role'],
            $data['content'],
            $data['created'],
            $name,
            $functionsStateId,
            $functionCall
        );
    }
}
