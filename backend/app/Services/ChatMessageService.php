<?php

namespace App\Services;

use App\Models\ChatSession;
use App\Models\Message;
use App\Services\AIService;
use App\Services\ChatLogger;

class ChatMessageService
{
    protected AIService $ai;
    protected ChatLogger $logger;

    public function __construct(AIService $ai, ChatLogger $logger)
    {
        $this->ai = $ai;
        $this->logger = $logger;
    }

    public function handleUserMessage(array $data): array
    {
        $session = ChatSession::findOrFail($data['chat_session_id']);

        $userMessage = Message::create([
            'chat_session_id' => $session->id,
            'sender_type'     => 'user',
            'content'         => $data['content'],
            'status'          => 'pending'
        ]);

        $aiResponse = $this->ai->chat($session, $data['content']);

        $this->logger->log($session, $this->ai->getLastRequest(), $aiResponse);

        $aiMessage = Message::create([
            'chat_session_id' => $session->id,
            'sender_type'     => 'ai',
            'content'         => $aiResponse['message']['content'] ?? '',
            'status'          => 'completed'
        ]);

        return [
            'user_message' => $userMessage,
            'ai_message'   => $aiMessage,
        ];
    }
}
