<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
        'unread',
    ];

    /**
     * Get the messages associated with the chat.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
