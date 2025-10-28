<?php

namespace App\Models\Backend;

use App\Enums\Enums\RecipeDifficulty;
use App\Enums\Enums\RecipeStatus;
use App\Models\Backend\Cuisine;
use App\Models\User;
use Database\Factories\RecipeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory;
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title', 'slug', 'description', 'instructions', 'prep_time', 'cook_time',
        'servings', 'difficulty', 'thumbnail', 'status', 'cuisine_id'
    ];

    public function cuisine()
    {
        return $this->belongsTo(Cuisine::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'recipe_category_pivot');
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function avergeRatings()
    {
        return (int) $this->ratings()->avg('rating');
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }

    public function favouriteCount()
    {
        return $this->favourites->count();
    }

    protected static function newFactory()
    {
        return RecipeFactory::new();
    }

    protected function casts(): array
    {
        return [
            'difficulty' => RecipeDifficulty::class,
            'status' => RecipeStatus::class,
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });

    }

}
