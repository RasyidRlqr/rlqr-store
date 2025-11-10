@extends('layouts.app') 

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">🎮 Manajemen Daftar Game</h1>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            + Tambah Game Baru
        </a>
    </div>
    @if($products->isEmpty())
        <div class="alert alert-info">Belum ada nominal top up yang ditambahkan.</div>
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
                        @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->game->name ?? 'N/A' }}</td>
                            <td>{{ $product->name }}</td>
                            <td class="text-end">{{ number_format($product->nominal, 0, ',', '.') }}</td>
                            <td class="text-end">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->is_active ? 'Ya' : 'Tidak' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning me-2">Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus produk ini?');">
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
                    {{ $products->links() }} </div>
            </div>
        </div>
    @endif
</div>
@endsection