<?php

namespace App\Models\Backend;

use App\Models\Backend\Recipe;
use Database\Factories\CuisineFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cuisine extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'image',
        'description'
    ];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? s3_url('cuisines/' . $value) : null,
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    protected static function newFactory()
    {
        return CuisineFactory::new();
    }
}
