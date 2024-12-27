<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'person_one_id',
        'person_two_id',
        'person_one_typing',
        'person_two_typing',
        'pending',
    ];

    /**
     * Get the person one associated with the chat.
     */
    public function personOne(): HasOne
    {
        return $this->hasOne(User::class, 'id','person_one_id');
    }

    /**
     * Get the person two associated with the chat.
     */
    public function personTwo(): HasOne
    {
        return $this->hasOne(User::class, 'id','person_two_id');
    }

    /**
     * Get the messages associated with the chat.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }
}
