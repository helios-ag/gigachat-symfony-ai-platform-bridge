<?php

namespace FM\AI\Platform\Bridge\GigaChat\AiCheck;

use Webmozart\Assert\Assert;

final class AiCheckResult
{
    /**
     * @param list<list{int,int}> $aiIntervals
     */
    public function __construct(
        public string $category,
        public int    $characters,
        public int    $tokens,
        public array  $aiIntervals,
    )
    {
    }
    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'category');
        Assert::string($data['category']);

        Assert::keyExists($data, 'characters');
        Assert::integer($data['characters']);

        Assert::keyExists($data, 'tokens');
        Assert::integer($data['tokens']);

        Assert::keyExists($data, 'ai_intervals');
        Assert::isArray($data['ai_intervals']);

        foreach ($data['ai_intervals'] as $interval) {
            Assert::isArray($interval);
            Assert::count($interval, 2);
            Assert::integer($interval[0]);
            Assert::integer($interval[1]);
        }

        /** @var list<array{int, int}> $intervals */
        $intervals = $data['ai_intervals'];

        return new self(
            $data['category'],
            $data['characters'],
            $data['tokens'],
            $intervals,
        );
    }
}