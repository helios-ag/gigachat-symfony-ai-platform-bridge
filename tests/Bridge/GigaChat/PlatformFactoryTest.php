<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat;

use FM\AI\Platform\Bridge\GigaChat\Contract\GigaChatContract;
use FM\AI\Platform\Bridge\GigaChat\PlatformFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;
use Symfony\AI\Platform\Platform;
use Symfony\Component\HttpClient\EventSourceHttpClient;
use Symfony\Component\HttpClient\MockHttpClient;

#[CoversClass(PlatformFactory::class)]
#[CoversClass(GigaChatContract::class)]
#[Small]
final class PlatformFactoryTest extends TestCase
{
    public function testItCreatesPlatformWithDefaultSettings(): void
    {
        $platform = PlatformFactory::create('test-api-key');

        $this->assertInstanceOf(Platform::class, $platform);
    }

    public function testItCreatesPlatformWithCustomHttpClient(): void
    {
        $httpClient = new MockHttpClient();
        $platform = PlatformFactory::create('test-api-key', $httpClient);

        $this->assertInstanceOf(Platform::class, $platform);
    }

    public function testItCreatesPlatformWithEventSourceHttpClient(): void
    {
        $httpClient = new EventSourceHttpClient(new MockHttpClient());
        $platform = PlatformFactory::create('test-api-key', $httpClient);

        $this->assertInstanceOf(Platform::class, $platform);
    }
}