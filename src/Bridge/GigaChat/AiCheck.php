<?php

namespace FM\AI\Platform\Bridge\GigaChat;

use Symfony\AI\Platform\Model;

class AiCheck extends Model
{
    public const GIGACHECKCLASSIFICATION = 'GigaCheckClassification';
    public const GIGACHECKDETECTION = 'GigaCheckDetection';

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(string $name = self::GIGACHECKCLASSIFICATION, array $options = [])
    {
        parent::__construct($name, [], $options);
    }
}