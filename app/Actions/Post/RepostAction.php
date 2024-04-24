<?php

namespace App\Actions\Post;

use App\Models\Post\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class RepostAction
{
    public function execute(array $data): void
    {
        $data['user_id'] = auth()->id();
        Post::create($data);
    }

}
