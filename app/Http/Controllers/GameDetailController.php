<?php

namespace App\Http\Controllers;

use App\Models\Game; // Import Model Game
use Illuminate\Http\Request;

class GameDetailController extends Controller
{
    /**
     * Display the specified game detail and its products.
     */
    public function show(Game $game) // Laravel otomatis mencari Game berdasarkan slug
    {
        // Ambil semua produk yang aktif dan terikat dengan game ini
        $products = $game->products()
                         ->where('is_active', true)
                         ->orderBy('price') // Urutkan berdasarkan harga termurah
                         ->get();

        // Kirim data game dan produk ke view
        return view('topup.show', compact('game', 'products'));
    }
}