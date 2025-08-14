<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChatSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ChatSession::all(); // вместо auth()->id()
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $session = ChatSession::create([
            // 'user_id' => Auth::id(),
            'user_id' => 1, // временно, пока нет auth
            'status' => 'active'
        ]);

        return response()->json($session, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ChatSession $chatSession)
    {
        $this->authorize('view', $chatSession);
        return $chatSession->load('messages');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChatSession $chatSession)
    {
        $this->authorize('update', $chatSession);
        $chatSession->update([
            'status' => $request->input('status', 'closed'),
            'ended_at' => now()
        ]);

        return $chatSession;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChatSession $chatSession)
    {
        $this->authorize('delete', $chatSession);
        $chatSession->delete();
        return response()->noContent();
    }
}
