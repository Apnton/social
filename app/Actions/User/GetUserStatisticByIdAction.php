<?php

namespace App\Actions\User;

use App\Models\Post\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class GetUserStatisticByIdAction
{
    public function execute(int $id): array
    {
        $user = User::where('id', $id)
            ->withCount(['subscribers', 'followings', 'posts'])
            ->firstOrFail();

        $statistic['subscribers_count'] = $user->subscribers_count;
        $statistic['followings_count'] = $user->followings_count;
        $statistic['posts_count'] = $user->posts_count;
        $statistic['likes_count'] = Post::select('id')->withCount('likes')->where('user_id', $id)->get()->sum('likes_count');

        return $statistic;
    }


}
