<?php

declare(strict_types=1);

namespace FM\AI\Platform\Bridge\GigaChat\Gpt\Output;

use Webmozart\Assert\Assert;


final readonly class FunctionCall
{
    /**
     * @param string               $name      Имя функции
     * @param array<string, mixed> $arguments Аргументы функции
     */
    public function __construct(
        public string $name,
        public array $arguments,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @throws \InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'name');
        Assert::keyExists($data, 'arguments');
        Assert::string($data['name']);
        Assert::isArray($data['arguments']);

        /** @var array<string, mixed> $arguments */
        $arguments = $data['arguments'];

        return new self($data['name'], $arguments);
    }
}
