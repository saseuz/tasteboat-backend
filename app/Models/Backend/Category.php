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
        'name', 'slug', 'image'
    ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? asset('storage/categories/' . $value) : null,
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name) . '-' . Str::uuid();
            }
        });

    }

    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
}
