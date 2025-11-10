@extends('layouts.app') 

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4 p-md-5">
                    <h3 class="text-center mb-4 fw-bold text-primary">Buat Akun Baru</h3>
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" name="password" required autocomplete="new-password">
                            @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            @error('password_confirmation')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Daftar Akun</button>
                        </div>
                    </form>
                    
                    <p class="text-center mt-3 small">
                        Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none">Login di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection