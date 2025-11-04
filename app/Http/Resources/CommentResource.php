<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatar' => $this->user->avatar,
            ],
            'content' => $this->content,
            'parent_id' => $this->parent_id,
            'replies' => count($this->replies) > 0 ? CommentResource::collection($this->whenLoaded('replies')) : null,
            'created_at' => $this->created_at->format('d-M-Y H:i:s'),
        ];
    }
}
