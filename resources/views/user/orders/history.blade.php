{{-- resources/views/user/orders/history.blade.php --}}

@extends('layouts.app') 

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">🛒 Riwayat Top Up Saya</h1>
    
    <div class="card shadow">
        <div class="card-body">
            
            @if($orders->isEmpty())
                <div class="alert alert-info text-center">
                    Anda belum pernah melakukan top up.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Game & Nominal</th>
                                <th>ID Game</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $order->invoice_number }}</span><br>
                                    <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                                </td>
                                <td>
                                    <strong>{{ $order->product->game->name ?? 'N/A' }}</strong><br>
                                    <small class="text-secondary">{{ $order->product->name ?? 'N/A' }}</small>
                                </td>
                                <td>{{ $order->game_user_id }}</td>
                                <td class="text-end">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    {{-- Status Badge --}}
                                    <span class="badge 
                                        @if($order->status == 'completed') bg-success
                                        @elseif($order->status == 'paid') bg-primary
                                        @elseif($order->status == 'processing') bg-warning text-dark
                                        @else bg-danger
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection