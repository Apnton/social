<?php

namespace App\Actions\Post;

use App\Models\Post\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAllPostsAction
{
    public function execute(?int $limit = 15): LengthAwarePaginator
    {
        $userId = auth()->id();

        return Post::query()
            ->withCount('repostedByPosts')
            ->where('user_id', '=', $userId)
            ->isLiked($userId)
            ->orderByDesc('created_at')
            ->paginate($limit);
    }

}
