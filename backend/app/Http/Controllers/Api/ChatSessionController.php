<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatSessionController extends Controller
{
    public function index()
    {
        return ChatSession::where('user_id', Auth::id())->get();
    }

    public function store(Request $request)
    {
        $session = ChatSession::create([
            'user_id' => Auth::id(),
            'status' => 'active'
        ]);
        return response()->json($session, 201);
    }

    public function show(ChatSession $chatSession)
    {
        $this->authorize('view', $chatSession);
        return $chatSession->load('messages');
    }

    public function update(Request $request, ChatSession $chatSession)
    {
        $this->authorize('update', $chatSession);
        $chatSession->update([
            'status' => $request->input('status', 'closed'),
            'ended_at' => now()
        ]);

        return $chatSession;
    }

    public function destroy(ChatSession $chatSession)
    {
        $this->authorize('delete', $chatSession);
        $chatSession->delete();
        return response()->noContent();
    }
}
