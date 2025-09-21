<?php

namespace FM\AI\Platform\Bridge\GigaChat\Files;

use FM\AI\Platform\Bridge\GigaChat\AbstractModelClient;
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
        return true;
    }

    public function request(Model $model, array|string $payload, array $options = []): RawHttpResult
    {
        $task = $options['task'] ?? Task::FILE_LIST;
        if (is_string($payload)) {
            throw new \InvalidArgumentException('Payload must be a string');
        }
        return match ($task) {
            Task::FILE_DELETE => new RawHttpResult($this->httpClient->request('POST', sprintf("%s/v1/files/%s/delete", self::getBaseUrl(), $payload), [
                'auth_bearer' => $this->apiKey,
            ])),
            Task::FILE_UPLOAD => new RawHttpResult($this->httpClient->request('POST', self::getBaseUrl() . '/v1/files', [
                'auth_bearer' => $this->apiKey,
                'headers' => [
                    'Content-Type' => 'multipart/form-data',
                ],
                'body' => array_merge($options, $payload),
            ])),
            Task::FILE_INFO => new RawHttpResult($this->httpClient->request('GET', sprintf("%s/v1/files/%s", self::getBaseUrl(), $payload), [
                'auth_bearer' => $this->apiKey,
            ])),
            default => new RawHttpResult($this->httpClient->request('POST', self::getBaseUrl() . '/v1/files', [
                'auth_bearer' => $this->apiKey,
            ])),
        };
    }
}

