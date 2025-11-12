<?php

namespace App\Models\Backend;

use App\Enums\Enums\RecipeDifficulty;
use App\Enums\Enums\RecipeStatus;
use App\Models\Backend\Cuisine;
use App\Models\User;
use Database\Factories\RecipeFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory, SoftDeletes;
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title', 'slug', 'description', 'instructions', 'prep_time', 'cook_time',
        'servings', 'difficulty', 'thumbnail', 'status', 'cuisine_id', 'user_id',
        'image',
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

    public function favouriteByUser()
    {
        $user = auth('api')->user();

        if (!$user) return null;

        return $this->favourites()
                ->where('user_id', $user->id)
                ->exists();
    }

    public function favouritedBy()
    {
        return $this->belongsToMany(User::class, 'favourites', 'recipe_id', 'user_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'recipe_id');
    }

    public function commentsWithoutReplies()
    {
        return $this->hasMany(Comment::class, 'recipe_id')->where('parent_id', null)->latest();
    }

    public function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset('storage/recipes/thumbnails/' . $value) : null,
        );
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset('storage/recipes/' . $value) : null,
        );
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
