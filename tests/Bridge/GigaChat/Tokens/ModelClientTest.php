<?php

namespace FM\AI\Platform\Tests\Bridge\GigaChat\Tokens;

use FM\AI\Platform\Bridge\GigaChat\GigaChat;
use FM\AI\Platform\Bridge\GigaChat\Tokens\ModelClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use Symfony\AI\Platform\Exception\InvalidArgumentException;
use Symfony\Component\HttpClient\EventSourceHttpClient;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface as HttpResponse;


#[CoversClass(ModelClient::class)]
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
        $modelClient = new ModelClient($httpClient, 'sk-valid-api-key');

        $this->assertInstanceOf(ModelClient::class, $modelClient);
    }

    public function testItIsSupportingTheCorrectModel(): void
    {
        $modelClient = new ModelClient(new MockHttpClient(), 'api-key');

        $this->assertTrue($modelClient->supports(new GigaChat()));
    }

    public function testItIsExecutingTheCorrectRequest(): void
    {
        $resultCallback = static function (string $method, string $url, array $options): HttpResponse {
            self::assertSame('POST', $method);
            self::assertSame('https://gigachat.devices.sberbank.ru/api/v1/tokens/count', $url);
            self::assertSame('Authorization: Bearer api-key', $options['normalized_headers']['authorization'][0]);
            self::assertSame('{"temperature":1,"model":"GigaChat-pro","messages":[{"role":"user","content":"test message"}]}', $options['body']);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient([$resultCallback]);
        $modelClient = new ModelClient($httpClient, 'api-key');
        $modelClient->request(new GigaChat(), ['model' => 'GigaChat-pro', 'messages' => [['role' => 'user', 'content' => 'test message']]], ['temperature' => 1]);
    }

    public function testItIsExecutingTheCorrectRequestWithArrayPayload(): void
    {
        $resultCallback = static function (string $method, string $url, array $options): HttpResponse {
            self::assertSame('POST', $method);
            self::assertSame('https://gigachat.devices.sberbank.ru/api/v1/tokens/count', $url);
            self::assertSame('Authorization: Bearer api-key', $options['normalized_headers']['authorization'][0]);
            self::assertSame('{"temperature":0.7,"model":"GigaChat-pro","messages":[{"role":"user","content":"Hello"}]}', $options['body']);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient([$resultCallback]);
        $modelClient = new ModelClient($httpClient, 'api-key');
        $modelClient->request(new GigaChat(), ['model' => 'GigaChat-pro', 'messages' => [['role' => 'user', 'content' => 'Hello']]], ['temperature' => 0.7]);
    }

    #[TestWith(['https://gigachat.devices.sberbank.ru/api/v1/tokens/count'])]
    public function testItUsesCorrectBaseUrl(?string $region, string $expectedUrl): void
    {
        $resultCallback = static function (string $method, string $url, array $options) use ($expectedUrl): HttpResponse {
            self::assertSame('POST', $method);
            self::assertSame($expectedUrl, $url);
            self::assertSame('Authorization: Bearer api-key', $options['normalized_headers']['authorization'][0]);

            return new MockResponse();
        };
        $httpClient = new MockHttpClient([$resultCallback]);
        $modelClient = new ModelClient($httpClient, 'api-key');
        $modelClient->request(new GigaChat(), ['messages' => []], []);
    }
}