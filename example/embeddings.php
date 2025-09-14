<?php

use FM\AI\Platform\Bridge\GigaChat\GigaChat;
use FM\AI\Platform\Bridge\GigaChat\PlatformFactory;

require_once dirname(__DIR__).'/bootstrap.php';

$platform = PlatformFactory::create(env('GIGACHAT_API_KEY'), env('GIGACHAT_HOST_URL'), http_client());

$response = $platform->invoke(new GigaChat(GigaChat::GIGACHAT_2), <<<TEXT
    Расскажи о современных технологиях
    TEXT);

echo 'Dimensions: '.$response->asVectors()[0]->getDimensions().\PHP_EOL;
