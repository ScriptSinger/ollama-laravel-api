<?php

namespace App\Filament\Pages;

use App\Services\MistralService;
use Filament\Pages\Page;

class Chat extends Page
{
    protected static string $view = 'filament.pages.chat';

    public string $prompt = '';
    public string $response = '';

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Чат с Mistral';

    public function send(): void
    {
        $mistralService = app(MistralService::class);
        $this->response = $mistralService->generate($this->prompt);
    }
}
