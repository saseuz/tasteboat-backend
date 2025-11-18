<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeListResource extends JsonResource
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
            'cuisine' => [
                'id' => $this->cuisine->id,
                'name' => $this->cuisine->name,
            ],
            'slug' => $this->slug,
            'status' => $this->status->label(),
            'difficulty' => $this->difficulty->label(),
            'prep_time' => $this->prep_time,
            'cook_time' => $this->cook_time,
            'servings' => $this->servings,
            'thumbnail' => $this->thumbnail,
            'created_at' => $this->created_at->format('d-M-Y H:i:s'),
            'ratings' => $this->avergeRatings(),
            'favourite_count' => $this->favouriteCount(),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatar' => $this->user->avatar,
            ],
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
        ];
    }
}
