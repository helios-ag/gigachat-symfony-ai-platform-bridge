<?php

use FM\AI\Platform\Bridge\GigaChat\GigaChat;
use FM\AI\Platform\Bridge\GigaChat\PlatformFactory;
use Symfony\AI\Platform\Message\Message;
use Symfony\AI\Platform\Message\MessageBag;

require_once dirname(__DIR__).'/bootstrap.php';

$platform = PlatformFactory::create(env('GIGACHAT_API_KEY'), http_client());
$model = new GigaChat(GigaChat::GIGACHAT_2);

$messages = new MessageBag(
    Message::forSystem('Ты — профессиональный переводчик на английский язык. Переведи точно сообщение пользователя.'),
    Message::ofUser('GigaChat — это сервис, который умеет взаимодействовать с пользователем в формате диалога, писать код, создавать тексты и картинки по запросу пользователя.'),
);

try {
    $result = $platform->invoke($model, $messages);
    echo $result->getResult()->getContent().\PHP_EOL;
} catch (InvalidArgumentException $e) {
    echo $e->getMessage()."\nМожет использовать другую модель?\n";
}
