<?php

namespace App\Services;

use App\Models\ChatSession;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected array $lastRequest = [];

    public function chat(ChatSession $session, string $content): array
    {
        $payload = [
            'model'    => config('services.ollama.model', 'mistral'),
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $content
                ]
            ],
            'stream' => false
        ];

        $this->lastRequest = $payload;
        $response = $this->callOllamaApi($payload);
        return $response;
    }

    public function getLastRequest(): array
    {
        return $this->lastRequest;
    }

    protected function callOllamaApi(array $payload): array
    {
        try {
            $response = Http::timeout(30)->post(config('services.ollama.base_url') . '/api/chat', $payload);
            if ($response->failed()) {
                Log::error('AIService::callOllamaApi - Ошибка запроса', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return ['error' => 'Ошибка AI API'];
            }

            $data = $response->json();
            if (!is_array($data)) {
                Log::error('AIService::callOllamaApi - Пустой или неверный ответ', ['body' => $response->body()]);
                return ['error' => 'Неверный ответ от AI API'];
            }

            return $data;
        } catch (\Throwable $e) {
            Log::error('AIService::callOllamaApi - Исключение', ['exception' => $e]);
            return ['error' => 'Исключение при вызове AI API'];
        }
    }
}
