<?php

declare(strict_types=1);

namespace FM\AI\Platform\Bridge\GigaChat\Gpt\Output;

use Webmozart\Assert\Assert;

final readonly class Choice
{
    public function __construct(
        public Message $message,
        public int $index,
        public string $finishReason,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @throws \InvalidArgumentException
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'message');
        Assert::keyExists($data, 'index');
        Assert::keyExists($data, 'finish_reason');

        Assert::isArray($data['message']);
        /** @var array<string, mixed> $msgRaw */
        $msgRaw = $data['message'];

        Assert::integer($data['index']);
        Assert::string($data['finish_reason']);

        return new self(
            Message::fromArray($msgRaw),
            $data['index'],
            $data['finish_reason']
        );
    }
}
