<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
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
        $messages = $this->chatService->handleUserMessage(
            $request->validated()
        );

        return response()->json($messages, 201);
    }
}
