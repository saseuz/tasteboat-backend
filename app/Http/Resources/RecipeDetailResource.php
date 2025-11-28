<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeDetailResource extends JsonResource
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
            'description' => $this->description,
            'instructions' => $this->instructions,
            'thumbnail' => $this->thumbnail,
            'image' => $this->image,
            'created_at' => $this->created_at->format('d-M-Y H:i:s'),
            'ratings' => $this->avergeRatings(),
            'favourite_count' => $this->favouriteCount(),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'avatar' => $this->user->avatar,
                'favourited' => $this->favouriteByUser(),
                'rated' => $this->ratedByUser(),
                'bio' => $this->user->bio,
            ],
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'ingredients' => IngredientResource::collection($this->whenLoaded('ingredients')),
        ];
    }
}
