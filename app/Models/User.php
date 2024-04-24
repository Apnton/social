<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Chat\ChatMessage;
use App\Models\Notification\Notification;
use App\Models\Post\Post;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscriber_followings', 'following_id', 'subscriber_id');
    }

    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'subscriber_followings', 'subscriber_id', 'following_id');
    }

    public function scopeIsSubscribe(Builder $query, ?int $userId): Builder
    {
        return $userId !== null ? $query->withExists(['subscribers as is_subscribe' => function ($q) use ($userId) {
            return $q->where('subscriber_id', $userId);
        }]) : $query;
    }

    public function likedPosts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'liked_posts', 'user_id', 'post_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    public function unreadMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'user_id', 'id')
            ->where('is_read', false);
    }


}
