<?php

namespace App\Models\Backend;

use App\Models\User;
use Database\Factories\FavouriteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'recipe_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    protected static function newFactory()
    {
        return FavouriteFactory::new();
    }
}
