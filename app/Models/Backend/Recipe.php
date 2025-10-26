<?php

namespace App\Models\Backend;

use App\Enums\Enums\RecipeDifficulty;
use App\Enums\Enums\RecipeStatus;
use App\Models\Backend\Cuisine;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Recipe extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'title', 'slug', 'description', 'instructrions', 'prep_time', 'cook_time',
        'servings', 'difficulty', 'thumbnail', 'status', 'cuisine_id'
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
