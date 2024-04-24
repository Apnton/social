<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->imageUrl,
            'is_liked' => $this->whenHas('is_liked'),
            'likes_count' => $this->whenHas('likes_count'),
            'comments_count' => $this->comments_count,
            'user' => UserResource::make($this->user),
            'reposted' =>  RepostedPostResource::make($this->repostedPost),
            'reposted_by_posts_count' => $this->whenHas('reposted_by_posts_count'),
            'created_at' => $this->dateOfPublication,
        ];
    }
}
