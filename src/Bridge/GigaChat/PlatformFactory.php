<?php

namespace FM\AI\Platform\Bridge\GigaChat;

use FM\AI\Platform\Bridge\GigaChat\Contract\GigaChatContract;
use Symfony\AI\Platform\Contract;
use Symfony\AI\Platform\Platform;
use Symfony\Component\HttpClient\EventSourceHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class PlatformFactory
{
    public static function create(
        #[\SensitiveParameter] string $apiKey,
        ?HttpClientInterface $httpClient = null,
        ?Contract $contract = null,
    ): Platform {
        $httpClient = $httpClient instanceof EventSourceHttpClient ? $httpClient : new EventSourceHttpClient($httpClient);

        return new Platform(
            [
                new AiCheck\ModelClient($httpClient, $apiKey),
                new Gpt\ModelClient($httpClient, $apiKey),
                new Embeddings\ModelClient($httpClient, $apiKey),
            ],
            [
                new AiCheck\ResultConverter(),
                new Gpt\ResultConverter(),
                new Embeddings\ResultConverter(),
        ],
            $contract ?? GigaChatContract::create(),
        );
    }
}