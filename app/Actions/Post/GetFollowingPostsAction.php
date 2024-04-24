<?php

namespace App\Actions\Post;

use App\Models\Post\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class GetFollowingPostsAction
{
    public function execute(?int $limit = 15): LengthAwarePaginator
    {
        $user = auth()->user();
        $posIds = $user->followings()->get()->pluck('id');
        $likedPost = $user->likedPosts->pluck('id');
        return Post::query()
            ->withCount('repostedByPosts')
            ->isLiked($user->id)
            ->whereIn('user_id', $posIds)
            ->whereNotIn('id', $likedPost)
            ->orderByDesc('created_at')
            ->paginate($limit);
    }
}
