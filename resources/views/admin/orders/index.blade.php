{{-- resources/views/admin/orders/index.blade.php --}}

@extends('layouts.app') 

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">🛒 Manajemen Pesanan (Non-Real Time)</h1>
    
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if($orders->isEmpty())
        <p class="text-gray-600">Tidak ada pesanan yang perlu diproses saat ini.</p>
    @else
        <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 text-black">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border-b text-left">Invoice</th>
                    <th class="py-2 px-4 border-b text-left">Game & Produk</th>
                    <th class="py-2 px-4 border-b text-left">ID User</th>
                    <th class="py-2 px-4 border-b text-right">Harga</th>
                    <th class="py-2 px-4 border-b text-center">Status</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="py-2 px-4 border-b font-semibold">{{ $order->invoice_number }}</td>
                    <td class="py-2 px-4 border-b">
                        <p class="font-bold">{{ $order->product->game->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">{{ $order->product->name ?? 'N/A' }}</p>
                    </td>
                    <td class="py-2 px-4 border-b">{{ $order->game_user_id }} <br><span class="text-xs text-blue-500">WA: {{ $order->contact_whatsapp }}</span></td>
                    <td class="py-2 px-4 border-b text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b text-center">
                        {{-- Tampilkan status dengan warna --}}
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($order->status == 'completed') bg-green-100 text-green-800
                            @elseif($order->status == 'paid') bg-blue-100 text-blue-800
                            @elseif($order->status == 'processing') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'pending') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border-b">
                        {{-- Form Aksi Status (Contoh: Hanya tampilkan dropdown untuk update status) --}}
                        <form action="{{ route('orders.update', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="border rounded text-sm p-1" onchange="this.form.submit()">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection