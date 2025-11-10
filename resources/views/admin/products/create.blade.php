{{-- resources/views/admin/products/create.blade.php --}}

@extends('layouts.app') 

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">➕ Tambah Nominal Top Up</h1>
    
    @if ($errors->any())
        {{-- Tampilkan Error Validasi (sama seperti di Game) --}}
    @endif

    {{-- Form Tambah Produk --}}
    <form action="{{ route('products.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        
        {{-- FIELD 1: PILIH GAME --}}
        <div class="mb-4">
            <label for="game_id" class="block text-gray-700 font-bold mb-2">Pilih Game:</label>
            <select name="game_id" id="game_id" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Pilih Game --</option>
                @foreach ($games as $game)
                    <option value="{{ $game->id }}" {{ old('game_id') == $game->id ? 'selected' : '' }}>
                        {{ $game->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        {{-- FIELD 2: NAMA NOMINAL --}}
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama Nominal (Contoh: 100 Diamonds):</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        {{-- FIELD 3: HARGA JUAL --}}
        <div class="mb-4">
            <label for="price" class="block text-gray-700 font-bold mb-2">Harga Jual (Rp):</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" min="100"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        {{-- FIELD 4: JUMLAH ITEM (NOMINAL) --}}
        <div class="mb-4">
            <label for="nominal" class="block text-gray-700 font-bold mb-2">Jumlah Item/Koin/Diamond:</label>
            <input type="number" name="nominal" id="nominal" value="{{ old('nominal') }}" min="1"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        
        {{-- FIELD 5: STATUS AKTIF --}}
        <div class="mb-6">
            <label for="is_active" class="block text-gray-700 font-bold mb-2">Status:</label>
            <select name="is_active" id="is_active" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', 0) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>
        
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Nominal
            </button>
            <a href="{{ route('products.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection