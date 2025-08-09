<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_session_id',
        'sender_type',
        'content',
        'status'
    ];

    public function chatSession()
    {
        return $this->belongsTo(ChatSession::class, 'chat_session_id');
    }
}
