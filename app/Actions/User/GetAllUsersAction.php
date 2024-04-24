<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class GetAllUsersAction
{
    public function execute(?int $limit = 15): LengthAwarePaginator
    {
        $userId = auth()->user()->getAuthIdentifier();

        return User::query()
            ->withCount('unreadMessages')
            ->whereNot('id', $userId)
            ->isSubscribe($userId)
            ->paginate($limit);
    }
}
