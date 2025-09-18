<?php

namespace FM\AI\Platform\Bridge\GigaChat\ValidateFunctions;

use FM\AI\Platform\Bridge\GigaChat\AbstractModelClient;
use FM\AI\Platform\Bridge\GigaChat\AiCheck;
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
        return $model instanceof AiCheck;
    }

    public function request(Model $model, array|string $payload, array $options = []): RawHttpResult
    {
        return new RawHttpResult($this->httpClient->request('POST', self::getBaseUrl().'/v1/functions/validate', [
            'auth_bearer' => $this->apiKey,
            'json' => array_merge($options, $payload),
        ]));
    }
}