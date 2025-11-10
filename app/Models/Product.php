<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Tambahkan ini

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'game_id',
        'name',
        'price',
        'nominal',
        'is_active',
    ];

    /**
     * Get the game that owns the product.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
    
    /**
     * Get the orders for the product.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}