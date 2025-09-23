<?php

declare(strict_types=1);

namespace FM\AI\Platform\Tests\Bridge\GigaChat\Gpt;

use FM\AI\Platform\Bridge\GigaChat\Gpt\GptResult;
use FM\AI\Platform\Bridge\GigaChat\Gpt\Output\Usage;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\TestCase;

#[CoversClass(GptResult::class)]
#[CoversClass(Usage::class)]
#[Small]
final class GptResultTest extends TestCase
{
    public function testParsesValidJson(): void
    {
        $data = json_decode($this->sampleJson(), true, 512, JSON_THROW_ON_ERROR);
        $completion = GptResult::fromArray($data);

        $this->assertSame(1678878333, $completion->created);
        $this->assertSame('GigaChat:1.0.26.20', $completion->model);
        $this->assertSame('chat.completion', $completion->object);

        $this->assertSame(1, $completion->usage->promptTokens);
        $this->assertSame(4, $completion->usage->completionTokens);
        $this->assertSame(37, $completion->usage->precachedPromptTokens);
        $this->assertSame(5, $completion->usage->totalTokens);

        $this->assertCount(1, $completion->choices);
        $choice = $completion->choices[0];
        $this->assertSame(0, $choice->index);
        $this->assertSame('stop', $choice->finishReason);

        $msg = $choice->message;
        $this->assertSame('assistant', $msg->role);
        $this->assertStringContainsString('GigaChat', $msg->content);
        $this->assertSame(1625284800, $msg->created);
        $this->assertSame('text2image', $msg->name);
        $this->assertSame('77d3fb14-457a-46ba-937e-8d856156d003', $msg->functionsStateId);

        $this->assertNotNull($msg->functionCall);
        $this->assertSame('string', $msg->functionCall->name);
        $this->assertSame([], $msg->functionCall->arguments);
    }

    public function testMissingChoicesThrows(): void
    {
        $data = json_decode($this->sampleJson(), true, 512, JSON_THROW_ON_ERROR);
        unset($data['choices']);

        $this->expectException(InvalidArgumentException::class);
        GptResult::fromArray($data);
    }

    public function testWrongTypeCreatedThrows(): void
    {
        $data = json_decode($this->sampleJson(), true, 512, JSON_THROW_ON_ERROR);
        $data['created'] = 'oops';

        $this->expectException(InvalidArgumentException::class);
        GptResult::fromArray($data);
    }

    private function sampleJson(): string
    {
        return <<<JSON
{
  "choices": [
    {
      "message": {
        "role": "assistant",
        "content": "Здравствуйте! К сожалению, я не могу дать точный ответ на этот вопрос, так как это зависит от многих факторов. Однако обычно релиз новых функций и обновлений в GigaChat происходит постепенно и незаметно для пользователей. Рекомендую следить за новостями и обновлениями проекта в официальном сообществе GigaChat или на сайте разработчиков.",
        "created": 1625284800,
        "name": "text2image",
        "functions_state_id": "77d3fb14-457a-46ba-937e-8d856156d003",
        "function_call": {
          "name": "string",
          "arguments": {}
        }
      },
      "index": 0,
      "finish_reason": "stop"
    }
  ],
  "created": 1678878333,
  "model": "GigaChat:1.0.26.20",
  "usage": {
    "prompt_tokens": 1,
    "completion_tokens": 4,
    "precached_prompt_tokens": 37,
    "total_tokens": 5
  },
  "object": "chat.completion"
}
JSON;
    }
}
