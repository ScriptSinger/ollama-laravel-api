<?php

namespace App\Jobs;

use App\Models\ChatSession;
use App\Models\Message;
use App\Services\AIService;
use App\Services\ChatLogger;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessUserMessage implements ShouldQueue
{
    use Queueable;


    protected int $messageId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * Execute the job.
     */
    public function handle(AIService $ai, ChatLogger $logger)
    {
        $userMessage = Message::findOrFail($this->messageId);
        $userMessage->update(['status' => 'processing']);

        $session = ChatSession::findOrFail($userMessage->chat_session_id);

        try {
            $aiResponse = $ai->chat($session, $userMessage->content);

            $logger->log($session, $ai->getLastRequest(), $aiResponse);

            Message::create([
                'chat_session_id' => $session->id,
                'sender_type'     => 'ai',
                'content'         => $aiResponse['message']['content'] ?? '',
                'status'          => 'completed'
            ]);

            $userMessage->update(['status' => 'completed']);
        } catch (\Throwable $e) {
            $userMessage->update(['status' => 'failed']);
            throw $e;
        }
    }
}
