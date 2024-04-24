<?php

namespace App\Actions\User;

use App\Models\User;

class ToggleFollowingAction
{
    public function execute(int $userId): User
    {
        $user = auth()->user();
        $user->followings()->toggle($userId);

        return User::where('id', $userId)->isSubscribe($user->getAuthIdentifier())->firstOrFail();

    }
}
