<?php

namespace FM\AI\Platform\Bridge\GigaChat\BatchRequest;

final class BatchResult
{
    public function __construct(
        public string $id,
        public string $method,
        public string $status,
        /** @var object{total:int} */
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
     *     request_counts: array{total:int},
     *     created_at: string,
     *     updated_at: string
     * } $data
     */
    public static function fromArray(array $data): self
    {
        /** @var object{total:int} $requestCounts */
        $requestCounts = (object) ['total' => (int) $data['request_counts']['total']];

        return new self(
            $data['id'],
            $data['method'],
            $data['status'],
            $requestCounts,
            $data['created_at'],
            $data['updated_at'],
        );
    }
}