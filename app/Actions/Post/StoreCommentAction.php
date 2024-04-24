<?php

namespace App\Actions\Post;

use App\Events\Notification\NewNotificationEvent;
use App\Models\Notification\NotificationDataDto;
use App\Models\Notification\NotificationEnum;
use App\Models\Post\Comment;
use App\Models\Post\Post;

class StoreCommentAction
{
    public function execute(array $data): Comment
    {
        $user = auth()->user();

        $data['user_id'] = $user->id;
        $userId = Post::select('user_id')->find($data['post_id'])->user_id;

        if ($data['user_id'] !== $userId)
            event(new NewNotificationEvent(NotificationEnum::NEW_COMMENT, $userId, new NotificationDataDto(userId: $data['user_id'], userName: $user->name)));

        return Comment::create($data);
    }

}
