<?php

namespace App\Events\Chat;

use App\Http\Resources\Chat\ChatMessageResource;
use App\Models\Chat\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreMessageStatusEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        private readonly int $count,
        private readonly int $userId
    )
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
            new Channel('store-message-status.' . $this->userId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'store-message-status';
    }

    public function broadcastWith(): array
    {
        return [
            'count' => $this->count,
            'user_id' => auth()->id()
        ];
    }
}
