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

        switch ($task) {
            case Task::FILE_DELETE:
                if (!is_string($payload)) {
                    throw new \InvalidArgumentException('Payload must be a string');
                }
                return new RawHttpResult($this->httpClient->request('POST', sprintf("%s/v1/files/%s/delete", self::getBaseUrl(), $payload), [
                    'auth_bearer' => $this->apiKey,
                ]));
            case Task::FILE_UPLOAD:
                if (is_string($payload)) {
                    throw new \InvalidArgumentException('Payload must not be a string');
                }
                return new RawHttpResult($this->httpClient->request('POST', self::getBaseUrl() . '/v1/files', [
                    'auth_bearer' => $this->apiKey,
                    'headers' => [
                        'Content-Type' => 'multipart/form-data',
                    ],
                    'body' => array_merge($options, $payload),
                ]));
            case Task::FILE_INFO:
                if (!is_string($payload)) {
                    throw new \InvalidArgumentException('Payload must be a string');
                }
                return new RawHttpResult($this->httpClient->request('GET', sprintf("%s/v1/files/%s", self::getBaseUrl(), $payload), [
                    'auth_bearer' => $this->apiKey,
                ]));
            default:
                return new RawHttpResult($this->httpClient->request('POST', self::getBaseUrl() . '/v1/files', [
                    'auth_bearer' => $this->apiKey,
                ]));
        }
    }
}

