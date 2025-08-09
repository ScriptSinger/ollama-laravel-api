<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['session_id', 'request_payload', 'response_payload'];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
    ];

    public function session()
    {
        return $this->belongsTo(ChatSession::class);
    }
}
