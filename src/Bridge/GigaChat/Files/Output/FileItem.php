<?php

declare(strict_types=1);

namespace FM\AI\Platform\Bridge\GigaChat\Files\Output;

final readonly class FileItem
{
    public function __construct(
        public int                $bytes,
        public \DateTimeImmutable $createdAt,
        public string             $filename,
        public string             $id,
        public string             $object,
        public string             $purpose,
        public string             $accessPolicy,
    ) {}

    /**
     * @param array<string,mixed> $in
     */
    public static function fromArray(array $in): self
    {
        return new self(
            bytes: (int)($in['bytes'] ?? 0),
            createdAt: (new \DateTimeImmutable())->setTimestamp((int)($in['created_at'] ?? 0)),
            filename: (string)($in['filename'] ?? ''),
            id: (string)($in['id'] ?? ''),
            object: (string)($in['object'] ?? ''),
            purpose: (string)($in['purpose'] ?? ''),
            accessPolicy: (string)($in['access_policy'] ?? ''),
        );
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'bytes'         => $this->bytes,
            'created_at'    => $this->createdAt->getTimestamp(),
            'filename'      => $this->filename,
            'id'            => $this->id,
            'object'        => $this->object,
            'purpose'       => $this->purpose,
            'access_policy' => $this->accessPolicy,
        ];
    }
}
