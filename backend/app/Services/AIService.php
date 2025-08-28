<?php

namespace App\Services;

use App\Models\ChatSession;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class AIService
{
    protected array $lastRequest = [];

    /**
     * Отправка сообщения в AI (основной чат-запрос).
     */
    public function sendChatMessage(string $content, array $history = []): array
    {
        $messages = array_merge($history, [
            [
                'role' => 'user',
                'content' => $content,
            ]
        ]);

        $payload = [
            'model'    => config('services.ollama.model', 'mistral'),
            'messages' => $messages,
            'stream'   => false,
        ];

        $this->lastRequest = $payload;
        return $this->callOllamaApi($payload);
    }

    /**
     * Генерация заголовка для чата на основе первого сообщения.
     */
    public function generateTitle(string $userMessage): ?string
    {
        $payload = [
            'model'    => config('services.ollama.model', 'mistral'),
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Сформулируй короткий, осмысленный заголовок (3-7 слов) для чата на основе пользовательского сообщения. Ответь только заголовком, без лишнего текста.'
                ],
                [
                    'role' => 'user',
                    'content' => $userMessage,
                ],
            ],
            'stream' => false,
        ];

        $this->lastRequest = $payload;
        $response = $this->callOllamaApi($payload);

        return $response['message']['content'] ?? null;
    }

    /**
     * Вернуть последний запрос (для логирования).
     */
    public function getLastRequest(): array
    {
        return $this->lastRequest;
    }

    /**
     * Вызов Ollama API.
     */
    protected function callOllamaApi(array $payload): array
    {
        try {
            $response = Http::timeout(60)->post(
                config('services.ollama.base_url') . '/v1/chat/completions',
                $payload
            );

            if ($response->failed()) {
                Log::error('AIService::callOllamaApi - Ошибка', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return ['error' => 'Ошибка AI API'];
            }

            $data = $response->json();
            if (!is_array($data)) {
                Log::error('AIService::callOllamaApi - Неверный ответ', ['body' => $response->body()]);
                return ['error' => 'Неверный ответ от AI API'];
            }

            // OpenAI совместимый ответ (Ollama возвращает choices)
            if (isset($data['choices'][0]['message'])) {
                return $data['choices'][0];
            }

            return $data;
        } catch (\Throwable $e) {
            Log::error('AIService::callOllamaApi - Исключение', ['exception' => $e]);
            return ['error' => 'Исключение при вызове AI API'];
        }
    }
}
