<?php

declare(strict_types=1);

namespace FM\AI\Platform\Bridge\GigaChat\Gpt\Output;

use Webmozart\Assert\Assert;

final readonly class Usage
{
    public function __construct(
        public int $promptTokens,
        public int $completionTokens,
        public ?int $precachedPromptTokens,
        public int $totalTokens,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @throws \InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'prompt_tokens');
        Assert::keyExists($data, 'completion_tokens');
        Assert::keyExists($data, 'total_tokens');

        Assert::integer($data['prompt_tokens']);
        Assert::integer($data['completion_tokens']);
        Assert::integer($data['total_tokens']);

        $precached = null;
        if (array_key_exists('precached_prompt_tokens', $data)) {
            Assert::nullOrInteger($data['precached_prompt_tokens']);
            /** @var int|null $precached */
            $precached = $data['precached_prompt_tokens'];
        }

        return new self(
            $data['prompt_tokens'],
            $data['completion_tokens'],
            $precached,
            $data['total_tokens']
        );
    }
}
