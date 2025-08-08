<?php

namespace App\Filament\Widgets;

use App\Services\MistralService;
use Filament\Widgets\Widget;

class MistralChatWidget extends Widget
{
    protected static string $view = 'filament.widgets.mistral-chat-widget';

    public string $prompt = '';
    public string $response = '';

    public function send()
    {
        $mistralService = app(MistralService::class);
        $this->response = $mistralService->generate($this->prompt);
    }
}
