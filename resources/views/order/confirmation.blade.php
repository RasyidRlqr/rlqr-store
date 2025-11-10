@extends('layouts.app') 

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0">Pesanan Berhasil Dibuat!</h4>
                </div>
                <div class="card-body p-4">
                    
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-danger">Total Bayar: Rp {{ number_format($order->total_price, 0, ',', '.') }}</h3>
                        <p class="text-muted">Invoice **#{{ $order->invoice_number }}**</p>
                        <p class="small text-warning">Status: Menunggu Pembayaran</p>
                    </div>

                    <hr>

                    {{-- DETAIL PESANAN YANG DIINPUT USER --}}
                    <h5 class="fw-bold mb-3 mt-4">1. Detail Pesanan Anda</h5>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item">Game: <strong class="float-end">{{ $order->product->game->name ?? 'N/A' }}</strong></li>
                        <li class="list-group-item">Nominal Top Up: <strong class="float-end">{{ $order->product->name ?? 'N/A' }}</strong></li>
                        <li class="list-group-item bg-light">ID Akun Game: <strong class="float-end">{{ $order->game_user_id }}</strong></li>
                        <li class="list-group-item">Kontak WhatsApp: <strong class="float-end">{{ $order->contact_whatsapp }}</strong></li>
                    </ul>

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
                            <p class="fw-bold">Metode: QRIS (Instant Scan)</p>
                            <div class="text-center p-3 bg-light border">
                                                                <p class="mt-2 small">Scan QRIS ini. Nominal pembayaran: **Rp {{ number_format($order->total_price, 0, ',', '.') }}**</p>
                            </div>
                            <p class="small text-muted mt-2">Pastikan nominal yang dibayarkan sama persis.</p>
                        @elseif ($order->payment_method == 'DANA (Virtual)')
                            <p class="fw-bold">Metode: DANA (Virtual Account)</p>
                            <div class="alert alert-primary">
                                Transfer ke Nomor DANA: **0812-XXXX-XXXX** atas nama Admin.
                            </div>
                            <p class="small text-muted">Order akan diproses setelah dana masuk ke rekening kami.</p>
                        @else
                            <div class="alert alert-danger">Instruksi untuk metode ini belum dikonfigurasi.</div>
                        @endif
                    </div>
                    
                    <div class="mt-4 text-center">
                        <small class="text-danger fw-bold">JANGAN TUTUP HALAMAN INI SEBELUM PEMBAYARAN SELESAI.</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection