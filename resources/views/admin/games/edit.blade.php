{{-- resources/views/admin/games/edit.blade.php --}}

@extends('layouts.app') 

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">✍️ Edit Game: {{ $game->name }}</h1>
    
    {{-- Error Validasi --}}
    @if ($errors->any())
        {{-- ... (sama seperti di create.blade.php) --}}
    @endif

    {{-- Form Edit Game --}}
    {{-- Perhatikan method PATCH dan penggunaan $game->id --}}
    <form action="{{ route('games.update', $game) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PATCH')
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama Game:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $game->name) }}" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi (Opsional):</label>
            <textarea name="description" id="description" rows="4" 
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description', $game->description) }}</textarea>
        </div>

        <div class="mb-6">
            <label for="is_active" class="block text-gray-700 font-bold mb-2">Status:</label>
            <select name="is_active" id="is_active" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="1" {{ old('is_active', $game->is_active) == 1 ? 'selected' : '' }}>Aktif (Tampil di Homepage)</option>
                <option value="0" {{ old('is_active', $game->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif (Disembunyikan)</option>
            </select>
        </div>
        
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Perubahan
            </button>
            <a href="{{ route('games.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection