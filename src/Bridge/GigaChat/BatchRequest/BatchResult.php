<?php

namespace FM\AI\Platform\Bridge\GigaChat\BatchRequest;

use Webmozart\Assert\Assert;

final class BatchResult
{
    public function __construct(
        public string $id,
        public string $method,
        public string $status,
        /** @var list<array{total:int}> */
        public array $requestCounts,
        public string $createdAt,
        public string $updatedAt,
    )
    {
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'id');
        Assert::string($data['id']);

        Assert::keyExists($data, 'method');
        Assert::string($data['method']);

        Assert::keyExists($data, 'status');
        Assert::string($data['status']);

        Assert::keyExists($data, 'request_counts');
        Assert::isArray($data['request_counts']);

        $counts = [];
        foreach ($data['request_counts'] as $row) {
            Assert::isArray($row);
            Assert::keyExists($row, 'total');
            Assert::integer($row['total']);
            $counts[] = ['total' => $row['total']];
        }
        Assert::keyExists($data, 'created_at');
        Assert::numeric($data['created_at']);

        Assert::keyExists($data, 'updated_at');
        Assert::numeric($data['updated_at']);

        return new self(
            $data['id'],
            $data['method'],
            $data['status'],
            $counts,
            $data['created_at'],
            $data['updated_at'],
        );
    }
}