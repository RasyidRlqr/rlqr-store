@extends('layouts.app') 

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">🎮 Manajemen Daftar Game</h1>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('games.create') }}" class="btn btn-primary">
            + Tambah Game Baru
        </a>
    </div>

    @if($games->isEmpty())
        <div class="alert alert-info">Belum ada game yang ditambahkan.</div>
    @else
        <div class="card shadow">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Game</th>
                            <th>Slug</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($games as $game)
                        <tr>
                            <td>{{ $game->id }}</td>
                            <td>{{ $game->name }}</td>
                            <td>{{ $game->slug }}</td>
                            <td>
                                <a href="{{ route('games.edit', $game) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                <form action="{{ route('games.destroy', $game) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $games->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection