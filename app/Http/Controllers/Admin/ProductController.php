<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Import Model Product
use App\Models\Game;    // Import Model Game
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data Product, dengan memuat (load) data Game terkait
        $products = Product::with('game')->latest()->paginate(15); 

        // Kirim data ke view
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua Game yang aktif untuk ditampilkan di dropdown
        $games = Game::where('is_active', true)->orderBy('name')->get(); 
        
        return view('admin.products.create', compact('games'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'game_id' => 'required|exists:games,id',
        'name' => [
            'required',
            'string',
            'max:255',
            // Rule::unique DIHAPUS SEMENTARA
        ],
        'price' => 'required|integer|min:100',
        'nominal' => 'required|integer|min:1',
        'is_active' => 'required|boolean',
    ]);

    // 2. Simpan Data
    Product::create([
        'game_id' => $request->game_id,
        'name' => $request->name,
        'price' => $request->price,
        'nominal' => $request->nominal,
        'is_active' => $request->is_active,
    ]);

    // 3. Redirect
    return redirect()->route('products.index')
        ->with('success', 'Nominal top up berhasil ditambahkan!');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) // Menggunakan Route Model Binding
    {
        // Ambil semua Game yang aktif untuk dropdown
        $games = Game::where('is_active', true)->orderBy('name')->get();
        
        // Tampilkan view edit dengan data Product dan Game
        return view('admin.products.edit', compact('product', 'games'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // 1. Validasi Data
        $request->validate([
        'game_id' => 'required|exists:games,id',
        'name' => [
            'required',
            'string',
            'max:255',
            // Rule::unique DIHAPUS SEMENTARA
        ],
        'price' => 'required|integer|min:100',
        'nominal' => 'required|integer|min:1',
        'is_active' => 'required|boolean',
    ]);

        // 2. Update Data
        $product->update([
            'game_id' => $request->game_id,
            'name' => $request->name,
            'price' => $request->price,
            'nominal' => $request->nominal,
            'is_active' => $request->is_active,
        ]);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('products.index')
                         ->with('success', 'Nominal top up berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Hapus Produk dari database
        $product->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('products.index')
                         ->with('success', 'Nominal top up berhasil dihapus!');
    }
}
