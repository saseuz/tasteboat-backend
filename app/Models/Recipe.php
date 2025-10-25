<?php

namespace App\Models;

use App\Enums\Enums\RecipeDifficulty;
use App\Enums\Enums\RecipeStatus;
use App\Models\Backend\Cuisine;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title', 'slug', 'description', 'instructrions', 'prep_time', 'cook_time',
        'servings', 'difficulty', 'thumbnail', 'status',
    ];

    protected function casts(): array
    {
        return [
            'difficulty' => RecipeDifficulty::class,
            'status' => RecipeStatus::class,
        ];
    }

    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
