<?php

namespace App\Models\Post;

use App\Models\User;
use App\Services\ImageServices;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;

    public const IMAGE_FOLDER = 'images/post';

    protected $with = ['user', 'repostedPost'];

    protected $withCount = ['likes', 'comments'];

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'image',
        'reposted_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function repostedPost(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'reposted_id', 'id');
    }

    public function repostedByPosts(): HasMany
    {
        return $this->hasMany(Post::class, 'reposted_id','id');
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn($image): ?string => $this->image ? Storage::disk(ImageServices::STORAGE_DISK)->url($this->image) : null
        );
    }

    protected function dateOfPublication(): Attribute
    {
        return Attribute::make(
            get: fn($created_at): ?string => $this->created_at ? $this->created_at->diffForHumans() : null
        );
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'liked_posts', 'post_id', 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function scopeIsLiked(Builder $query, ?int $userId): Builder
    {
        return $userId !== null ? $query->withExists(['likes as is_liked' => function ($q) use ($userId) {
            return $q->where('user_id', $userId);
        }]) : $query;
    }



}
