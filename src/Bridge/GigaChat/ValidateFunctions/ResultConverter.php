<?php

namespace FM\AI\Platform\Bridge\GigaChat\ValidateFunctions;

use Symfony\AI\Platform\Model;
use Symfony\AI\Platform\Result\ObjectResult;
use Symfony\AI\Platform\Result\RawResultInterface;
use Symfony\AI\Platform\ResultConverterInterface;

final class ResultConverter implements ResultConverterInterface
{
    public function supports(Model $model): bool
    {
        return true;
    }

    public function convert(RawResultInterface $result, array $options = []): ObjectResult
    {
        $data = $result->getData();

        return new ObjectResult(ValidateFunctionsResult::fromArray($data));
    }
}