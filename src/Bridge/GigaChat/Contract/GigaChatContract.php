<?php

namespace FM\AI\Platform\Bridge\GigaChat\Contract;

use Symfony\AI\Platform\Contract;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final readonly class GigaChatContract extends Contract
{
    public static function create(NormalizerInterface ...$normalizer): Contract
    {
        return parent::create(
            ...$normalizer,
        );
    }
}