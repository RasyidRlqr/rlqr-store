@extends('layouts.app') 

@section('content')
<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-dark">{{ $game->name }} Top Up Center</h1>
    </div>

    {{-- Form Kontainer Utama --}}
    <form id="topup-form" method="POST" action="{{ route('order.store') }}">
        @csrf
        <input type="hidden" name="game_id" value="{{ $game->id }}">
        <input type="hidden" name="product_id" id="selected_product_id" value="" required> 
        <input type="hidden" name="payment_method" id="selected_payment_method" value="" required>
        
        <div class="row g-4">
            
            {{-- KOLOM KIRI: INPUT ID PENGGUNA --}}
            <div class="col-md-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">1. Masukkan ID Pengguna</h5>
                    </div>
                    <div class="card-body">
                        {{-- Field ID Pengguna --}}
                        <div class="mb-3">
                            <label for="game_user_id" class="form-label fw-bold">ID Pengguna:</label>
                            <input type="text" id="game_user_id" name="game_user_id" 
                                class="form-control shadow-sm"
                                placeholder="Masukkan ID Game Anda" required>
                        </div>
                        
                        {{-- Field Kontak WhatsApp --}}
                        <div class="mb-3">
                            <label for="contact_whatsapp" class="form-label fw-bold">Nomor WhatsApp:</label>
                            <input type="text" id="contact_whatsapp" name="contact_whatsapp" 
                                class="form-control shadow-sm"
                                placeholder="Contoh: 62812xxxxxx" required>
                        </div>

                        <hr>
                        <h6 class="mt-4 fw-bold">Tentang Game</h6>
                        <p class="text-muted small">{{ $game->description ?? 'Deskripsi game belum tersedia.' }}</p>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (2/3): NOMINAL & PEMBAYARAN --}}
            <div class="col-md-8">
                
                {{-- BAGIAN 2: PILIH NOMINAL TOP UP --}}
                <div class="card shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">2. Pilih Nominal Top Up</h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-2 row-cols-md-4 g-3">
                            @forelse ($products as $product)
                                <div class="col">
                                    <input type="radio" name="product_selection" id="product-{{ $product->id }}" value="{{ $product->id }}" 
                                           class="d-none product-radio" data-price="{{ $product->price }}" required>
                                    <label for="product-{{ $product->id }}" 
                                           class="card h-100 text-center p-3 border border-secondary shadow-sm card-radio-option"
                                           style="cursor: pointer;">
                                        
                                        <p class="mb-1 fw-bold text-dark">{{ $product->name }}</p>
                                        <p class="mb-0 text-muted small">({{ number_format($product->nominal, 0, ',', '.') }} Item)</p>
                                        <p class="fw-bolder text-success fs-5 mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </label>
                                </div>
                            @empty
                                <div class="col-12"><div class="alert alert-warning">Nominal belum tersedia.</div></div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">3. Pilih Metode Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- TRANSFER MANUAL --}}
                            <div class="col-md-4">
                                <input type="radio" name="payment_selection" id="payment-bca" value="Transfer Bank BCA" 
                                    class="d-none payment-radio" required>
                                <label for="payment-bca" class="card p-3 border border-secondary shadow-sm card-radio-option">Transfer Bank BCA</label>
                            </div>
                            
                            {{-- VIRTUAL PAYMENT (DANA) --}}
                            <div class="col-md-4">
                                <input type="radio" name="payment_selection" id="payment-dana" value="DANA (Virtual)" 
                                    class="d-none payment-radio" required>
                                <label for="payment-dana" class="card p-3 border border-secondary shadow-sm card-radio-option">DANA (Virtual)</label>
                            </div>
                            
                            {{-- QRIS --}}
                            <div class="col-md-4">
                                <input type="radio" name="payment_selection" id="payment-qris" value="QRIS" 
                                    class="d-none payment-radio" required>
                                <label for="payment-qris" class="card p-3 border border-secondary shadow-sm card-radio-option">QRIS</label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL SUBMIT --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-danger btn-lg w-75 shadow-lg">
                        Beli Sekarang dan Lanjutkan Pembayaran
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        const setActiveState = (element) => {
            document.querySelectorAll('.card-radio-option').forEach(label => {
                label.style.borderColor = '#ccc';
                label.style.backgroundColor = '#fff';
            });
            element.style.borderColor = '#0d6efd'; 
            element.style.backgroundColor = '#e7f1ff'; 
        };

        // 1. Logika Pilih Nominal
        document.querySelectorAll('.product-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('selected_product_id').value = this.value;
                setActiveState(this.nextElementSibling);
            });
        });

        // 2. Logika Pilih Metode Pembayaran
        document.querySelectorAll('.payment-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                document.getElementById('selected_payment_method').value = this.value;
                setActiveState(this.nextElementSibling); 
            });
        });
    });
</script>
@endsection