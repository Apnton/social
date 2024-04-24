<?php

namespace App\Actions\Post;

use App\Models\Post\Comment;
use Illuminate\Support\Collection;

class GetCommentsByPostIdAction
{
    public function execute(int $postId): Collection
    {
        return Comment::where('post_id', $postId)
            ->whereNull('parent_id')
            ->with('children')
            ->latest()
            ->get();
    }
}
