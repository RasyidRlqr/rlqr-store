<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Order.php
// ...
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'game_id',
        'invoice_number',
        'game_user_id',
        'game_user_server',
        'contact_whatsapp',
        'total_price',
        'payment_method',
        'status',
        'admin_notes',
        'paid_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Walaupun Order terikat ke Product, kita bisa tambahkan relasi ke Game
    // untuk kemudahan akses data (berguna saat menampilkan riwayat pesanan)
    public function game(): BelongsTo
    {
        // Asumsi Product model sudah punya relasi ke Game
        return $this->product->game();
    }
}