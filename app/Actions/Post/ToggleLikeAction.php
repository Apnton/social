<?php

namespace App\Actions\Post;


use App\Events\Notification\NewNotificationEvent;
use App\Models\Notification\NotificationDataDto;
use App\Models\Notification\NotificationEnum;
use App\Models\Post\Post;

class ToggleLikeAction
{
    public function execute(int $postId): Post
    {
        $user = auth()->user();
        $result = $user->likedPosts()->toggle($postId);

        if (!empty($result['attached'])) {

            $userId = Post::select('user_id')->find($postId)->user_id;

            if ($user->id !== $userId) {
                event(new NewNotificationEvent(NotificationEnum::NEW_LIKE, $userId,
                        new NotificationDataDto(userId: $user->id, userName: $user->name)
                    )
                );
            }

        }

        return Post::where('id', $postId)->IsLiked($user->id)->first();
    }


}
