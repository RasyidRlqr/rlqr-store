<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game; // Import Model Game
// app/Http/Controllers/Admin/GameController.php
use Illuminate\Support\Str; // Import Str untuk membuat slug

class GameController extends Controller
{
    public function index() 
    {
        // Ambil semua data Game dari database
        $games = Game::latest()->paginate(10); 

        // Kirim data ke view
        return view('admin.games.index', compact('games'));
    }
    
    public function create()
    {
        // Tampilkan view form tambah game
        return view('admin.games.create');
    }


    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'name' => 'required|string|max:255|unique:games,name',
            'description' => 'nullable|string',
            // Jika ada kolom image, tambahkan: 'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // 2. Simpan Data
        Game::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name), // Otomatis membuat slug dari nama
        ]);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('games.index')
                         ->with('success', 'Game berhasil ditambahkan!');
    }

    public function edit(Game $game) // Menggunakan Route Model Binding
    {
        // Tampilkan view edit dengan data Game yang dipilih
        return view('admin.games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        // 1. Validasi Data
        $request->validate([
            // Memastikan nama unik, tapi mengabaikan Game yang sedang di-edit
            'name' => 'required|string|max:255|unique:games,name,' . $game->id, 
            'description' => 'nullable|string',
            'is_active' => 'required|boolean', // Validasi untuk status aktif/tidak aktif
        ]);

        // 2. Update Data
        $game->update([
            'name' => $request->name,
            'description' => $request->description,
            // Slug hanya diubah jika nama berubah (kita asumsikan nama harus selalu di-slug)
            'slug' => Str::slug($request->name), 
            'is_active' => $request->is_active,
        ]);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('games.index')
                         ->with('success', 'Game berhasil diperbarui!');
    }

    public function destroy(Game $game)
    {
        // Hapus Game dari database
        $game->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('games.index')
                         ->with('success', 'Game berhasil dihapus!');
    }

}