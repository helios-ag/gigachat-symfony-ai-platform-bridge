<?php

namespace FM\AI\Platform\Bridge\GigaChat;

use Symfony\AI\Platform\Model;

final class GigaChat extends Model
{
    public const GIGACHAT_2 = 'GigaChat-2';
    public const GIGACHAT_2_2_Pro = 'GigaChat-2-Pro';
    public const GIGACHAT_2_Max = 'GigaChat-2-Max';

    public function __construct(
        string $name = self::GIGACHAT_2,
        array $options = [],
    ) {
        parent::__construct($name, [], $options);
    }
}