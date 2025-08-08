<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MistralService
{
    public function generate(string $prompt): string
    {
        $response = Http::post(config('services.mistral.url'), [
            'model' => config('services.mistral.model'),
            'prompt' => $prompt,
            'stream' => false,
        ]);

        return $response->json('response') ?? '';
    }
}
