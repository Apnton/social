<?php

namespace App\Actions\Chat;

use App\Models\Chat\ChatMessage;
use Illuminate\Pagination\LengthAwarePaginator;

class GetMessagesByChatIdAction
{
    public function execute(int $chatId, ?int $limit = 15): LengthAwarePaginator
    {
        $messages = ChatMessage::where('chat_id', $chatId)
            ->latest()->paginate($limit);

        $messageIds = $messages->pluck('id');
        ChatMessage::whereIn('id', $messageIds)
            ->where('user_id', '!=', auth()->id())
            ->update(['is_read' => true]);

        return $messages;

    }

}
