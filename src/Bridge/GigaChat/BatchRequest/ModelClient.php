<?php

namespace FM\AI\Platform\Bridge\GigaChat\BatchRequest;

use FM\AI\Platform\Bridge\GigaChat\AbstractModelClient;
use FM\AI\Platform\Bridge\GigaChat\AiCheck;
use FM\AI\Platform\Bridge\GigaChat\Embeddings;
use FM\AI\Platform\Bridge\GigaChat\GigaChat;
use Symfony\AI\Platform\Model;
use Symfony\AI\Platform\ModelClientInterface;
use Symfony\AI\Platform\Result\RawHttpResult;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class ModelClient extends AbstractModelClient implements ModelClientInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
        #[\SensitiveParameter] private string $apiKey,
    ) {
        self::validateApiKey($apiKey);
    }

    public function supports(Model $model): bool
    {
        return $model instanceof GigaChat || $model instanceof Embeddings;
    }

    public function request(Model $model, array|string $payload, array $options = []): RawHttpResult
    {
        return new RawHttpResult($this->httpClient->request('POST', self::getBaseUrl().'/v1/batches', [
            'auth_bearer' => $this->apiKey,
            'headers' => [
                'Content-Type' => 'application/octet-stream',
                'Accept' => 'application/json',
            ],
            'body' => $payload,
        ]));
    }
}