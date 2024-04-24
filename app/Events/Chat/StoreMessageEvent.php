<?php

namespace App\Events\Chat;

use App\Http\Resources\Chat\ChatMessageResource;
use App\Models\Chat\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(private readonly ChatMessage $message)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('store-message.'.$this->message->chat_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'store-message';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => ChatMessageResource::make($this->message)
        ];
    }
}
