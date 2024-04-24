<?php

namespace App\Models\Post;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $with = ['user'];
    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'body',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    protected function dateOfPublication(): Attribute
    {
        return Attribute::make(
            get: fn($created_at): ?string => $this->created_at ? $this->created_at->diffForHumans() : null
        );
    }


}
