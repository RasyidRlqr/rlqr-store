<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the products (top-up nominals) for the game.
     */
    public function products(): HasMany
    {
        // Karena Product memiliki foreign key 'game_id'
        return $this->hasMany(Product::class);
    }
}