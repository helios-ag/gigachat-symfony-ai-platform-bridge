<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat\ValidateFunctions\Output;

use FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\Output\Error;
use PHPUnit\Framework\TestCase;

final class ErrorTest extends TestCase
{
    public function testFromArrayCreatesInstance(): void
    {
        $data = [
            'description' => 'few_shot_examples are missing',
            'schema_location' => '(root)',
        ];

        $warning = Error::fromArray($data);

        $this->assertInstanceOf(Error::class, $warning);
        $this->assertSame('few_shot_examples are missing', $warning->description);
        $this->assertSame('(root)', $warning->schemaLocation);
    }
}
