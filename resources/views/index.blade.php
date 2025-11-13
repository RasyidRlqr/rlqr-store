@extends('layouts.app') 

@section('content')
{{-- Hero Section --}}
<div class="hero-section bg-gradient-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Top Up Koin Game Instan!</h1>
                <p class="lead mb-4">Pilih game favoritmu, top up dalam hitungan detik. Aman, cepat, dan terpercaya!</p>
                <div class="d-flex gap-3">
                    <a href="#games" class="btn btn-light btn-lg px-4">
                        <i class="fas fa-gamepad me-2"></i>Mulai Top Up
                    </a>
                    <button class="btn btn-outline-light btn-lg px-4" onclick="document.getElementById('chatbot-toggle').click()">
                        <i class="fas fa-comments me-2"></i>Tanya Bot
                    </button>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://via.placeholder.com/400x300?text=Gaming+Illustration" alt="Gaming" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    {{-- Search Bar --}}
  <div class="row justify-content-center mb-5">
    <div class="col-md-8">
        <div class="input-group input-group-lg">
            {{-- Ganti bg-white -> bg-body --}}
            <span class="input-group-text bg-body border-end-0"> 
                <i class="fas fa-search text-body-secondary"></i> 
            </span>
            {{-- Hapus class statis, Bootstrap akan menangani warna input --}}
            <input type="text" placeholder="Cari Game, misalnya Mobile Legends..." class="form-control border-start-0 shadow-sm">
            <button class="btn btn-primary px-4" type="button">
                <i class="fas fa-search me-2"></i>Cari
            </button>
        </div>
    </div>
</div>

    {{-- Features --}}
   <div class="row text-center mb-5">
    {{-- Card 1 --}}
    <div class="col-md-4">
        {{-- Ganti bg-light -> bg-body / text-muted -> text-body-secondary --}}
        <div class="feature-card p-4 bg-body rounded shadow-sm border"> 
            <i class="fas fa-bolt text-warning fa-3x mb-3"></i>
            <h5 class="fw-bold text-body">Instan</h5>
            <p class="text-body-secondary">Top up langsung dikirim setelah pembayaran</p>
        </div>
    </div>
    {{-- Ulangi untuk Card 2 & 3 --}}
    <div class="col-md-4">
        <div class="feature-card p-4 bg-body rounded shadow-sm border">
             <i class="fas fa-shield-alt text-success fa-3x mb-3"></i>
            <h5 class="fw-bold text-body">Aman</h5>
            <p class="text-body-secondary">Transaksi terlindungi dengan enkripsi</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="feature-card p-4 bg-body rounded shadow-sm border">
            <i class="fas fa-headset text-primary fa-3x mb-3"></i>
            <h5 class="fw-bold text-body">24/7 Support</h5>
            <p class="text-body-secondary">Customer service siap membantu kapan saja</p>
        </div>
    </div>
</div>

    <h2 id="games" class="mb-4 text-center">
        <i class="fas fa-fire text-danger me-2"></i>Game Populer
    </h2>

    {{-- Daftar Game (Grid) --}}
   <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">
    @forelse ($games as $game)
        <div class="col">
            {{-- PERBAIKAN: Ganti bg-white statis menjadi bg-body tema --}}
            <div class="game-card card h-100 shadow-sm border-0 text-decoration-none text-body bg-body position-relative overflow-hidden">
                <a href="{{ route('topup.show', $game->slug) }}" class="text-decoration-none text-body">
                    {{-- Gambar Game Placeholder --}}
                    <div class="card-img-wrapper position-relative">
                        <img src="https://via.placeholder.com/300x200?text={{ urlencode($game->name) }}"
                                alt="{{ $game->name }}"
                                class="card-img-top">
                        {{-- Overlay harus selalu terlihat (putih) di kedua mode --}}
                        <div class="card-img-overlay d-flex align-items-center justify-content-center bg-dark bg-opacity-50 opacity-0 hover-overlay">
                            <span class="text-white fw-bold">Top Up Sekarang</span>
                        </div>
                    </div>

                    <div class="card-body text-center p-3">
                        {{-- Ganti class text-dark menjadi text-body --}}
                        <h6 class="card-title fw-bold mb-2 text-body text-truncate">{{ $game->name }}</h6>
                        {{-- Badge harus tetap terlihat baik di mode terang maupun gelap --}}
                        <span class="badge bg-success-subtle text-success">Tersedia</span> 
                    </div>
                </a>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center border-0 shadow-sm bg-body">
                <i class="fas fa-info-circle me-2"></i>Belum ada game aktif yang tersedia saat ini.
            </div>
        </div>
    @endforelse
</div>

{{-- Modern Floating Chatbot --}}
<div id="chatbot-widget" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
    <div id="chatbot-container" class="d-none bg-white border rounded shadow-lg" style="width: 350px; height: 500px; display: flex; flex-direction: column;">
        <div class="bg-gradient-primary text-white p-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="fas fa-robot me-2"></i>
                <span class="fw-bold">TopUp Assistant</span>
            </div>
            <button id="chatbot-close" class="btn btn-sm btn-outline-light">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="chatbot-messages" class="flex-grow-1 p-3 overflow-auto bg-light">
            <div class="bot-message mb-3">
                <div class="d-flex">
                    <div class="bg-primary text-white rounded p-2 me-2">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="bg-white border rounded p-2 flex-grow-1">
                        <p class="mb-2">Halo! Saya TopUp Assistant. Saya bisa membantu Anda dengan:</p>
                        <div class="d-flex flex-wrap gap-1">
                            <button class="btn btn-sm btn-outline-primary quick-reply" data-reply="Pilih Game">Pilih Game</button>
                            <button class="btn btn-sm btn-outline-primary quick-reply" data-reply="Cara Top Up">Cara Top Up</button>
                            <button class="btn btn-sm btn-outline-primary quick-reply" data-reply="Status Pesanan">Status Pesanan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-3 border-top bg-white">
            <div class="input-group">
                <input type="text" id="chatbot-input" class="form-control" placeholder="Ketik pesan Anda..." disabled>
                <button class="btn btn-primary" id="chatbot-send" disabled>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
    <button id="chatbot-toggle" class="btn btn-primary rounded-circle shadow-lg" style="width: 60px; height: 60px;">
        <i class="fas fa-comments"></i>
    </button>
</div>
<footer class="text-center bg-body-tertiary">
  <!-- Grid container -->
  <div class="container pt-4">
    <!-- Section: Social media -->
    <section class="mb-4">
     
      <!-- Instagram -->
      <a
        data-mdb-ripple-init
        class="btn btn-link btn-floating btn-lg text-body m-1"
        href="https://www.instagram.com/rasyid_rlqr"
        role="button"
        data-mdb-ripple-color="dark"
        ><i class="fab fa-instagram"></i
      ></a>

      <!-- Linkedin -->
      <a
        data-mdb-ripple-init
        class="btn btn-link btn-floating btn-lg text-body m-1"
        href="https://www.linkedin.com/in/ikhwan-rasyid-b9727b396/"
        role="button"
        data-mdb-ripple-color="dark"
        ><i class="fab fa-linkedin"></i
      ></a>
      <!-- Github -->
      <a
        data-mdb-ripple-init
        class="btn btn-link btn-floating btn-lg text-body m-1"
        href="https://github.com/RasyidRlqr"
        role="button"
        data-mdb-ripple-color="dark"
        ><i class="fab fa-github"></i
      ></a>
    </section>
    <!-- Section: Social media -->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2025 Copyright:
    <a class="text-body" href="#">rlqr-store.anomalihitam.my.id</a>
  </div>
  <!-- Copyright -->
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotContainer = document.getElementById('chatbot-container');
    const chatbotClose = document.getElementById('chatbot-close');
    const chatbotInput = document.getElementById('chatbot-input');
    const chatbotSend = document.getElementById('chatbot-send');
    const chatbotMessages = document.getElementById('chatbot-messages');

    // Toggle chatbot
    chatbotToggle.addEventListener('click', function() {
        chatbotContainer.classList.toggle('d-none');
        if (!chatbotContainer.classList.contains('d-none')) {
            chatbotInput.disabled = false;
            chatbotSend.disabled = false;
            chatbotInput.focus();
        }
    });

    chatbotClose.addEventListener('click', function() {
        chatbotContainer.classList.add('d-none');
    });

    // Send message
    function sendMessage() {
        const message = chatbotInput.value.trim();
        if (message) {
            addMessage('user', message);
            chatbotInput.value = '';
            showTypingIndicator();
            setTimeout(() => {
                hideTypingIndicator();
                const response = getBotResponse(message);
                addMessage('bot', response);
            }, 1000 + Math.random() * 1000);
        }
    }

    chatbotSend.addEventListener('click', sendMessage);
    chatbotInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // Quick replies
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('quick-reply')) {
            const reply = e.target.getAttribute('data-reply');
            addMessage('user', reply);
            showTypingIndicator();
            setTimeout(() => {
                hideTypingIndicator();
                const response = getBotResponse(reply);
                addMessage('bot', response);
            }, 1000);
        }
    });

    function addMessage(sender, text) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `mb-3 ${sender === 'user' ? 'text-end' : 'text-start'}`;
        if (sender === 'user') {
            messageDiv.innerHTML = `
                <div class="d-inline-block bg-primary text-white rounded p-2 max-w-75">
                    ${text}
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="d-flex">
                    <div class="bg-primary text-white rounded p-2 me-2">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="bg-white border rounded p-2 flex-grow-1">
                        ${text}
                    </div>
                </div>
            `;
        }
        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    function showTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.id = 'typing-indicator';
        indicator.className = 'mb-3 text-start';
        indicator.innerHTML = `
            <div class="d-flex">
                <div class="bg-primary text-white rounded p-2 me-2">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="bg-white border rounded p-2">
                    <div class="typing-dots">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>
        `;
        chatbotMessages.appendChild(indicator);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    function hideTypingIndicator() {
        const indicator = document.getElementById('typing-indicator');
        if (indicator) {
            indicator.remove();
        }
    }

    function getBotResponse(message) {
        const lowerMessage = message.toLowerCase();
        if (lowerMessage.includes('pilih game') || lowerMessage.includes('game')) {
            return `
                <p>Silakan pilih game favorit Anda dari daftar di atas. Game populer saat ini:</p>
                <ul>
                    <li>Mobile Legends</li>
                    <li>Free Fire</li>
                    <li>PUBG Mobile</li>
                    <li>Genshin Impact</li>
                </ul>
                <p>Klik pada game yang diinginkan untuk mulai top up!</p>
            `;
        } else if (lowerMessage.includes('cara top up') || lowerMessage.includes('panduan')) {
            return `
                <p>Cara top up di TopUp.ID:</p>
                <ol>
                    <li>Pilih game yang ingin di-top up</li>
                    <li>Pilih jumlah koin/diamond yang diinginkan</li>
                    <li>Masukkan ID game Anda</li>
                    <li>Pilih metode pembayaran</li>
                    <li>Lakukan pembayaran</li>
                    <li>Koin akan dikirim otomatis setelah pembayaran dikonfirmasi</li>
                </ol>
            `;
        } else if (lowerMessage.includes('status pesanan') || lowerMessage.includes('pesanan')) {
            return `
                <p>Untuk melihat status pesanan Anda:</p>
                <ul>
                    <li>Login ke akun Anda</li>
                    <li>Kunjungi menu "Riwayat Pesanan"</li>
                    <li>Atau hubungi customer service jika ada masalah</li>
                </ul>
                <p>Pesanan biasanya diproses dalam 1-5 menit setelah pembayaran.</p>
            `;
        } else if (lowerMessage.includes('harga') || lowerMessage.includes('biaya')) {
            return 'Harga top up bervariasi tergantung game dan jumlah koin. Silakan lihat detail di halaman game yang dipilih.';
        } else if (lowerMessage.includes('pembayaran') || lowerMessage.includes('bayar')) {
            return 'Kami menerima berbagai metode pembayaran: Transfer Bank, E-wallet (GoPay, OVO, Dana), dan Kartu Kredit. Semua transaksi aman dan terjamin.';
        } else {
            return `
                <p>Maaf, saya belum bisa menjawab pertanyaan itu secara detail. Coba tanyakan tentang:</p>
                <div class="d-flex flex-wrap gap-1 mt-2">
                    <button class="btn btn-sm btn-outline-primary quick-reply" data-reply="Pilih Game">Pilih Game</button>
                    <button class="btn btn-sm btn-outline-primary quick-reply" data-reply="Cara Top Up">Cara Top Up</button>
                    <button class="btn btn-sm btn-outline-primary quick-reply="Status Pesanan">Status Pesanan</button>
                </div>
            `;
        }
    }
});
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 60vh;
}
.feature-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}
.game-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}
.game-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}
.card-img-wrapper {
    position: relative;
    overflow: hidden;
}
.hover-overlay {
    transition: opacity 0.3s ease;
}
.game-card:hover .hover-overlay {
    opacity: 1 !important;
}
.max-w-75 {
    max-width: 75%;
}
.typing-dots {
    display: inline-block;
}
.typing-dots span {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #6c757d;
    animation: typing 1.4s infinite ease-in-out;
    margin: 0 2px;
}
.typing-dots span:nth-child(1) { animation-delay: -0.32s; }
.typing-dots span:nth-child(2) { animation-delay: -0.16s; }
.typing-dots span:nth-child(3) { animation-delay: 0s; }
@keyframes typing {
    0%, 80%, 100% { transform: scale(0); opacity: 0.5; }
    40% { transform: scale(1); opacity: 1; }
}
</style>
@endsection