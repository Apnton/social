<?php

namespace App\Http\Resources\Chat;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => UserResource::make($this->user),
            'is_owner' => $this->isOwner,
            'time' => $this->time,
        ];
    }
}
