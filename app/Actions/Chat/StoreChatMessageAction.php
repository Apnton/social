<?php

namespace App\Actions\Chat;

use App\Events\Chat\StoreMessageEvent;
use App\Events\Chat\StoreMessageStatusEvent;
use App\Models\Chat\ChatMessage;

class StoreChatMessageAction
{
    public function execute(array $data): ChatMessage
    {
        $data['user_id'] = auth()->id();
        $message = ChatMessage::create($data);

        $count = $message->where('user_id', $data['user_id'])->where('is_read', false)->count();
        $users = explode('-', $message->chat->users);
        $userId = array_filter($users, fn($item) => $item != $data['user_id']);

        broadcast(new StoreMessageStatusEvent($count, reset($userId)))->toOthers();
        broadcast(new StoreMessageEvent($message))->toOthers();
        return $message;
    }

}
