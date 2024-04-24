<?php

namespace App\Actions\Post;

use App\Models\Post\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class GetPostsByUserAction
{
    public function execute(int $userId, ?int $limit = 15): LengthAwarePaginator
    {
        return Post::where('user_id', $userId)
            ->withCount('repostedByPosts')
            ->isLiked(auth()->id())
            ->paginate($limit);
    }
}
