{{-- resources/views/order/confirmation.blade.php (KODE FINAL) --}}

@extends('layouts.app') 

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                
                {{-- HEADER SESUAI STATUS --}}
                <div class="card-header 
                    @if($order->status == 'completed') bg-success 
                    @elseif(in_array($order->status, ['paid', 'processing'])) bg-primary 
                    @else bg-warning text-dark
                    @endif text-white text-center">
                    <h4 class="mb-0">
                        @if ($order->status == 'completed') Pesanan Selesai! 🎉
                        @elseif ($order->status == 'paid' || $order->status == 'processing') Pesanan Sedang Diproses...
                        @else Menunggu Pembayaran
                        @endif
                    </h4>
                </div>

                <div class="card-body p-4">

                    @if ($order->status == 'completed')
                        {{-- STATE 3: ORDER SUDAH SELESAI --}}
                        <div class="text-center">
                            <h2 class="text-success fw-bold">Top Up Selesai! 🎉</h2>
                            <p class="lead">Diamond/Koin telah berhasil masuk ke akun **{{ $order->game_user_id }}** Anda.</p>
                        </div>

                    @elseif (in_array($order->status, ['paid', 'processing']))
                        {{-- STATE 2: SEDANG DIPROSES / DIVERIFIKASI --}}
                        <div class="text-center">
                            <h2 class="text-warning fw-bold">Pesanan Sedang Diverifikasi/Diproses!</h2>
                            <p class="lead">Pesanan Anda sedang diisi oleh Admin. Mohon tunggu.</p>
                            <div class="spinner-border text-primary mt-3" role="status"></div>
                        </div>

                    @elseif ($order->status == 'pending')
                        {{-- STATE 1: MENUNGGU PEMBAYARAN USER (TAMPILKAN INSTRUKSI LENGKAP) --}}
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-danger">Total Bayar: Rp {{ number_format($order->total_price, 0, ',', '.') }}</h3>
                            <p class="small text-warning">Status: Menunggu Pembayaran</p>
                        </div>
                        
                        {{-- INSTRUKSI PEMBAYARAN --}}
                        <h5 class="fw-bold mb-3 mt-4">2. Instruksi Pembayaran ({{ $order->payment_method }})</h5>
                        <div class="p-3 border rounded">
                             @if (str_contains($order->payment_method, 'Transfer Bank'))
                                <p class="fw-bold">Metode: Transfer Bank Manual</p>
                                <div class="alert alert-info">
                                    Mohon transfer **tepat Rp {{ number_format($order->total_price, 0, ',', '.') }}** ke Rekening berikut:
                                    <ul class="mt-2 mb-0">
                                        <li>BANK: **MANDIRI**</li>
                                        <li>No. Rek: **1234-5678-9012** (a/n TopUp Admin)</li>
                                    </ul>
                                </div>
                                <p class="small text-muted">Setelah transfer, Admin akan memverifikasi dalam 5-15 menit.</p>
                            @elseif ($order->payment_method == 'QRIS')
                                <div class="alert alert-warning text-dark text-center">
                                    <p class="fw-bold mb-2">SCAN QRIS</p>
                                    
                                    <p class="small mt-2">Scan QRIS ini. Nominal pembayaran: **Rp {{ number_format($order->total_price, 0, ',', '.') }}**</p>
                                </div>
                            @endif
                        </div>

                        {{-- TOMBOL LANJUT (KONFIRMASI MANUAL) --}}
                        <div class="mt-4 text-center">
                            <h5 class="mt-4">Langkah Selanjutnya</h5>
                            <p class="text-muted">Setelah Anda selesai membayar, klik tombol di bawah:</p>
                            
                            {{-- Tombol yang mengalihkan user ke halaman status yang sama (untuk merefresh status) --}}
                            <a href="{{ route('order.status.view', $order->invoice_number) }}" 
                               class="btn btn-success btn-lg">
                                SAYA SUDAH BAYAR, LANJUTKAN
                            </a>
                        </div>
                        
                    @else
                        {{-- STATE LAINNYA (Failed/Canceled) --}}
                         <div class="alert alert-danger">Pesanan ini telah dibatalkan atau gagal.</div>
                    @endif

                    {{-- DETAIL ORDER (Selalu Tampil) --}}
                    <hr class="my-4">
                    <h6 class="fw-bold">Detail Order:</h6>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item bg-light">ID Akun Game: <strong class="float-end">{{ $order->game_user_id }}</strong></li>
                        <li class="list-group-item">Nominal: <strong class="float-end">{{ $order->product->name ?? 'N/A' }}</strong></li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection