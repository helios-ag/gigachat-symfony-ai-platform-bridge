<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat\AiCheck;

use FM\AI\Platform\Bridge\GigaChat\AiCheck;
use FM\AI\Platform\Bridge\GigaChat\AiCheck\ModelClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\AI\Platform\Exception\InvalidArgumentException;
use Symfony\Component\HttpClient\EventSourceHttpClient;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface as HttpResponse;


#[CoversClass(ModelClient::class)]
#[UsesClass(AiCheck::class)]
#[Small]
final class ModelClientTest extends TestCase
{
    public function testItThrowsExceptionWhenApiKeyIsEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The API key must not be empty.');

        new ModelClient(new MockHttpClient(), '');
    }

    public function testItAcceptsValidApiKey(): void
    {
        $modelClient = new ModelClient(new MockHttpClient(), 'valid-api-key');

        $this->assertInstanceOf(ModelClient::class, $modelClient);
    }

    public function testItWrapsHttpClientInEventSourceHttpClient(): void
    {
        $httpClient = new MockHttpClient();
        $modelClient = new ModelClient($httpClient, 'valid-api-key');

        $this->assertInstanceOf(ModelClient::class, $modelClient);
    }

    public function testItAcceptsEventSourceHttpClientDirectly(): void
    {
        $httpClient = new EventSourceHttpClient(new MockHttpClient());
        $modelClient = new ModelClient($httpClient, 'valid-api-key');

        $this->assertInstanceOf(ModelClient::class, $modelClient);
    }

    public function testItIsSupportingTheCorrectModel()
    {
        $modelClient = new ModelClient(new MockHttpClient(), 'api-key');

        $this->assertTrue($modelClient->supports(new AiCheck()));
    }

    public function testItIsExecutingTheCorrectRequest()
    {
        $resultCallback = static function (string $method, string $url, array $options): HttpResponse {
            self::assertSame('POST', $method);
            self::assertSame('https://gigachat.devices.sberbank.ru/api/v1/ai/check', $url);
            self::assertSame('Authorization: Bearer api-key', $options['normalized_headers']['authorization'][0]);
            self::assertSame('{"model":"GigaCheckClassification","input":"test message"}', $options['body']);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient([$resultCallback]);
        $modelClient = new ModelClient($httpClient, 'api-key');
        $modelClient->request(new AiCheck(), 'test message');
    }

    public function testItIsExecutingTheCorrectRequestWithArrayPayload()
    {
        $resultCallback = static function (string $method, string $url, array $options): HttpResponse {
            self::assertSame('POST', $method);
            self::assertSame('https://gigachat.devices.sberbank.ru/api/v1/ai/check', $url);
            self::assertSame('Authorization: Bearer api-key', $options['normalized_headers']['authorization'][0]);
            self::assertSame('{"model":"GigaCheckClassification","input":"Hello"}', $options['body']);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient([$resultCallback]);
        $modelClient = new ModelClient($httpClient, 'api-key');
        $modelClient->request(new AiCheck(), 'Hello');
    }

    #[TestWith(['https://gigachat.devices.sberbank.ru/api/v1/ai/check'])]
    public function testItUsesCorrectBaseUrl(string $expectedUrl)
    {
        $resultCallback = static function (string $method, string $url, array $options) use ($expectedUrl): HttpResponse {
            self::assertSame('POST', $method);
            self::assertSame($expectedUrl, $url);
            self::assertSame('Authorization: Bearer api-key', $options['normalized_headers']['authorization'][0]);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient([$resultCallback]);
        $modelClient = new ModelClient($httpClient, 'api-key',);
        $modelClient->request(new AiCheck(), ['input' => 'test message']);
    }
}