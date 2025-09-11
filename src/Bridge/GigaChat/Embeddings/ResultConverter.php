<?php

namespace FM\AI\Platform\Bridge\GigaChat\Embeddings;

use FM\AI\Platform\Bridge\GigaChat\Embeddings;
use RuntimeException;
use Symfony\AI\Platform\Model;
use Symfony\AI\Platform\Result\RawHttpResult;
use Symfony\AI\Platform\Result\RawResultInterface;
use Symfony\AI\Platform\ResultConverterInterface;
use Symfony\AI\Platform\Result\VectorResult;
use Symfony\AI\Platform\Vector\Vector;

final class ResultConverter implements ResultConverterInterface
{
    public function supports(Model $model): bool
    {
        return $model instanceof Embeddings;
    }

    public function convert(RawResultInterface $result, array $options = []): VectorResult
    {
        $data = $result->getData();

        if (!isset($data['data'])) {
            if ($result instanceof RawHttpResult) {
                throw new RuntimeException(\sprintf('Response from GigaChat API does not contain "data" key. StatusCode: "%s". Response: "%s".',
                    $result->getObject()->getStatusCode(),
                    json_encode($result->getData(), \JSON_THROW_ON_ERROR)));
            }

            throw new RuntimeException('Response does not contain data.');
        }

        return new VectorResult(
            ...array_map(
            static fn (array $item): Vector => new Vector($item['embedding']),
            $data['data']
        ),
        );
    }
}