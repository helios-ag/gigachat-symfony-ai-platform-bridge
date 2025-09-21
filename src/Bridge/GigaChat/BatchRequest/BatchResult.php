<?php

namespace FM\AI\Platform\Bridge\GigaChat\BatchRequest;

final class BatchResult
{
    public function __construct(
        public string $id,
        public string $method,
        public string $status,
        public object $requestCounts,
        public string $createdAt,
        public string $updatedAt,
    )
    {
    }

    /**
     * @param array{
     *     id: string,
     *     method: string,
     *     status: string,
     *     request_counts: array<array{total:int}>,
     *     created_at: string,
     *     updated_at: string,
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['method'],
            $data['status'],
            fn(int $total): object => (object)['request_counts' => (object)['array' => ['total' => $total]]],
            $data['created_at'],
            $data['updated_at'],
        );
    }
}