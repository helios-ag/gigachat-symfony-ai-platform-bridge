<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat\ValidateFunctions\Output;

use PHPUnit\Framework\TestCase;
use FM\AI\Platform\Bridge\GigaChat\ValidateFunctions\Output\Warning;

final class WarningTest extends TestCase
{
    public function testFromArrayCreatesInstance(): void
    {
        $data = [
            'description' => 'few_shot_examples are missing',
            'schema_location' => '(root)',
        ];

        $warning = Warning::fromArray($data);

        $this->assertInstanceOf(Warning::class, $warning);
        $this->assertSame('few_shot_examples are missing', $warning->description);
        $this->assertSame('(root)', $warning->schemaLocation);
    }
}
