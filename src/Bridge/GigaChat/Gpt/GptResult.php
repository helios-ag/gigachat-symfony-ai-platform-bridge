<?php

namespace FM\AI\Platform\Bridge\GigaChat\Gpt;

use FM\AI\Platform\Bridge\GigaChat\Gpt\Output\Choice;
use FM\AI\Platform\Bridge\GigaChat\Gpt\Output\Usage;
use Webmozart\Assert\Assert;

final class GptResult
{
    /** @var Choice[] */
    public array $choices;

    /** @param list<Choice> $choices */
    public function __construct(
        array $choices,
        public int $created,
        public string $model,
        public Usage $usage,
        public string $object,
    ) {
        $this->choices = $choices;
    }

    /**
     * @param array<string, mixed> $data
     * @throws \InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'choices');
        Assert::keyExists($data, 'created');
        Assert::keyExists($data, 'model');
        Assert::keyExists($data, 'usage');
        Assert::keyExists($data, 'object');

        Assert::isArray($data['choices']);
        Assert::integer($data['created']);
        Assert::string($data['model']);
        Assert::isArray($data['usage']);
        Assert::string($data['object']);

        /** @var Choice[] $choices */
        $choices = [];
        foreach ($data['choices'] as $row) {
            Assert::isArray($row);
            /** @var array<string, mixed> $row */
            $choices[] = Choice::fromArray($row);
        }

        /** @var array<string, mixed> $usageRaw */
        $usageRaw = $data['usage'];
        $usage = Usage::fromArray($usageRaw);

        return new self(
            $choices,
            $data['created'],
            $data['model'],
            $usage,
            $data['object']
        );
    }
}