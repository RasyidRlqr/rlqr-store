@extends('layouts.app') 

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Dashboard Saya</h5>
        </div>
        <div class="card-body">
            <p class="lead">Selamat datang kembali, **{{ Auth::user()->name }}**!</p>
            <p class="text-muted">Di sini Anda bisa mengelola akun dan melacak pesanan Anda.</p>
            
            <hr>

            <div class="row g-3">
                
                {{-- Card 1: Edit Profil --}}
                <div class="col-md-4">
                    <a href="{{ route('profile.edit') }}" class="card text-decoration-none bg-warning text-dark shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">⚙️ Edit Profil</h5>
                            <p class="card-text small">Ubah nama, email, atau password.</p>
                        </div>
                    </a>
                </div>
                
                {{-- Card 2: Riwayat Top Up --}}
                <div class="col-md-4">
                    <a href="{{ route('user.orders.history') }}" class="card text-decoration-none bg-secondary text-white shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">🛒 Riwayat Top Up</h5>
                            <p class="card-text small">Lihat semua status pesanan.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection