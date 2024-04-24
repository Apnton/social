<?php

namespace App\Models\Chat;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    protected $with = ['user'];

    protected $fillable = [
        'user_id',
        'chat_id',
        'body',
        'is_read',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function time(): Attribute
    {
        return Attribute::make(
            get: fn($created_at) =>  $this->created_at->diffForHumans()
        );
    }

    protected function isOwner(): Attribute
    {
        return Attribute::make(
            get: fn() =>  (int) $this->user_id ===  (int) auth()->id()
        );
    }

    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'id');
    }



}
