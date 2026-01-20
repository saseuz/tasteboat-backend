<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class Admin extends Authenticatable
{
    use HasRoles, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile',
        'bio'
    ];

    protected $hidden = ['password'];

    public function profile(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? s3_url('admins/' . $value) : null,
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

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
