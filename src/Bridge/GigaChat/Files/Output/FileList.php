<?php

namespace FM\AI\Platform\Bridge\GigaChat\Files\Output;

final readonly class FileList
{
    /** @var FileItem[] */
    public array $data;

    /**
     * @param FileItem[] $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromArray(array $data): self
    {
        $items = [];
        foreach (($data['data'] ?? []) as $row) {
            if (is_array($row)) {
                $items[] = FileItem::fromArray($row);
            }
        }
        return new self($items);
    }
}
