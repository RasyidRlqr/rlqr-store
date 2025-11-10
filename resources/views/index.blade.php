@extends('layouts.app') 

@section('content')
<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-dark">Top Up Koin Game Instan!</h1>
        <p class="lead text-muted">Pilih game favoritmu dan beli sekarang.</p>
    </div>

    {{-- Search Bar --}}
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <input type="text" placeholder="Cari Game, misalnya Mobile Legends..." 
                   class="form-control form-control-lg shadow-sm">
        </div>
    </div>

    <h2 class="mb-4 text-center border-bottom pb-2">🔥 Game Populer</h2>
    
    {{-- Daftar Game (Grid) --}}
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">
        
        @forelse ($games as $game)
            <div class="col">
                <a href="{{ route('topup.show', $game->slug) }}" class="card h-100 shadow-sm border-0 text-decoration-none text-dark bg-white">
                    {{-- Gambar Game Placeholder --}}
                    <img src="https://via.placeholder.com/300x400?text={{ $game->slug }}" 
                         alt="{{ $game->name }}" 
                         class="card-img-top" style="height: 150px; object-fit: cover;">
                    
                    <div class="card-body text-center p-3">
                        <h5 class="card-title fw-bold mb-0 text-truncate">{{ $game->name }}</h5>
                        <p class="card-text text-muted small">Top Up Sekarang</p>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">Belum ada game aktif yang tersedia saat ini.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection