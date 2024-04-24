<?php

namespace App\Actions\Chat;

use App\Models\Chat\Chat;

class StoreChatAction
{
    public function execute(array $data): int
    {
        $users = $data['users'];
        sort($users);
        $userIds = implode('-', $users);

        return Chat::firstOrCreate([
            'users' => $userIds
        ], ['title' => $data['title'] ?? null])->id;

    }

}
