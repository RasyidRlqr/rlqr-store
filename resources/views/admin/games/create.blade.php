{{-- resources/views/admin/games/create.blade.php --}}

@extends('layouts.app') 

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">➕ Tambah Game Baru</h1>
    
    {{-- Tampilkan Error Validasi --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Ada masalah dengan input Anda:</span>
            <ul class="mt-2 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Game --}}
    <form action="{{ route('games.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nama Game:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Deskripsi (Opsional):</label>
            <textarea name="description" id="description" rows="4" 
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('description') }}</textarea>
        </div>
        
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Simpan Game
            </button>
            <a href="{{ route('games.index') }}" class="inline-block align-baseline font-bold text-sm text-gray-500 hover:text-gray-800">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection