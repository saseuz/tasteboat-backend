<?php

namespace App\Models\Backend;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description'
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_category_pivot');
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? s3_url('categories/' . $value) : null,
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name) . '-' . random_int(1, now()->format('mdyHis'));
            }
        });

    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}
