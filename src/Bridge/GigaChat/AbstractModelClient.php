<?php

namespace FM\AI\Platform\Bridge\GigaChat;

use Symfony\AI\Platform\Exception\InvalidArgumentException;


abstract readonly class AbstractModelClient
{
    protected static function getBaseUrl(): string
    {
        return 'https://gigachat.devices.sberbank.ru/api';

    }

    protected static function getOauthUrl(): string
    {
        return 'https://ngw.devices.sberbank.ru:9443/api/v2/oauth';

    }

    protected static function validateApiKey(string $apiKey): void
    {
        if ('' === $apiKey) {
            throw new InvalidArgumentException('The API key must not be empty.');
        }
    }
}
