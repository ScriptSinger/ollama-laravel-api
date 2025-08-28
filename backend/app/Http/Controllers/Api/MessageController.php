<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Jobs\ProcessUserMessage;
use App\Models\Message;
use App\Services\ChatMessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class MessageController extends Controller
{

    protected ChatMessageService $chatService;

    public function __construct(ChatMessageService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function store(StoreMessageRequest $request): JsonResponse
    {
        $message = Message::create([
            'chat_session_id' => $request->chat_session_id,
            'sender_type'     => 'user',
            'content'         => $request->content,
            'status'          => 'pending',
        ]);

        // Отправляем в очередь (AI worker возьмет задачу)
        ProcessUserMessage::dispatch($message->id)->onQueue('ai');

        return response()->json([
            'id'      => $message->id,
            'status'  => $message->status,
        ], 202);
    }


    public function show($message): JsonResponse
    {
        $message = Message::findOrFail($message);

        if (!$message) {
            return response()->json([
                'message' => 'Message not found',
            ], 404);
        }

        return response()->json([
            'id'              => $message->id,
            'chat_session_id' => $message->chat_session_id,
            'sender_type'     => $message->sender_type,
            'content'         => $message->content,
            'status'          => $message->status,
            'created_at'      => $message->created_at,
        ]);
    }
}
