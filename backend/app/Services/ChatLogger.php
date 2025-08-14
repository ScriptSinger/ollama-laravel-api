<?php

namespace App\Services;

use App\Models\ChatSession;
use App\Models\Log as ChatLog;

class ChatLogger
{
    public function log(ChatSession $session, array $request, array $response): void
    {
        ChatLog::create([
            'chat_session_id'  => $session->id,
            'request_payload'  => $request,
            'response_payload' => $response
        ]);
    }
}
