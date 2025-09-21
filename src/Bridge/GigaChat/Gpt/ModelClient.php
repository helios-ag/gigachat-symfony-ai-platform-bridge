<?php

namespace FM\AI\Platform\Bridge\GigaChat\Gpt;

use FM\AI\Platform\Bridge\GigaChat\AbstractModelClient;
use FM\AI\Platform\Bridge\GigaChat\GigaChat;
use Symfony\AI\Platform\Model;
use Symfony\AI\Platform\ModelClientInterface;
use Symfony\AI\Platform\Result\RawHttpResult;
use Symfony\Component\HttpClient\EventSourceHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class ModelClient extends AbstractModelClient implements ModelClientInterface
{
    private EventSourceHttpClient $httpClient;

    public function __construct(
        HttpClientInterface $httpClient,
        #[\SensitiveParameter] private string $apiKey,
    ) {
        $this->httpClient = $httpClient instanceof EventSourceHttpClient ? $httpClient : new EventSourceHttpClient($httpClient);
        self::validateApiKey($apiKey);
    }

    public function supports(Model $model): bool
    {
        return $model instanceof GigaChat;
    }

    public function request(Model $model, array|string $payload, array $options = []): RawHttpResult
    {
        if (!is_array($payload)) {
            throw new \InvalidArgumentException('Payload must be an array');
        }
        return new RawHttpResult($this->httpClient->request('POST', self::getBaseUrl().'/v1/chat/completions', [
            'auth_bearer' => $this->apiKey,
            'json' => array_merge($options, $payload),
        ]));
    }
}