<?php

namespace FM\AI\Platform\Bridge\GigaChat\Tokens;

use Webmozart\Assert\Assert;

final class TokensCountResult
{
    public function __construct(
        public string $object,
        public int    $tokens,
        public int    $characters,
    )
    {
    }
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'object');
        Assert::string($data['object']);
        Assert::keyExists($data, 'tokens');
        Assert::integer($data['tokens']);
        Assert::keyExists($data, 'characters');
        Assert::integer($data['characters']);

        return new self(
            $data['object'],
            $data['tokens'],
            $data['characters'],
        );
    }
}