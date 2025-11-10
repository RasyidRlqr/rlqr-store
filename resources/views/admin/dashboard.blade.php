@extends('layouts.app') 

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Panel Administrasi</h1>
    
    <div class="row g-4">
        
        {{-- Card 1: Manajemen Game --}}
        <div class="col-md-4">
            <a href="{{ route('games.index') }}" class="card text-decoration-none shadow bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">🎮 Kelola Game</h5>
                    <p class="card-text">Tambah, edit, dan hapus daftar game.</p>
                </div>
            </a>
        </div>

        {{-- Card 2: Manajemen Produk --}}
        <div class="col-md-4">
            <a href="{{ route('products.index') }}" class="card text-decoration-none shadow bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">💎 Kelola Nominal</h5>
                    <p class="card-text">Atur harga dan nominal top up.</p>
                </div>
            </a>
        </div>

        {{-- Card 3: Manajemen Pesanan --}}
        <div class="col-md-4">
            <a href="{{ route('orders.index') }}" class="card text-decoration-none shadow bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">🛒 Proses Pesanan</h5>
                    <p class="card-text">Verifikasi pembayaran dan update status.</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection