{{-- resources/views/layouts/navigation_bs.blade.php (FINAL DENGAN DARK MODE) --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-opacity-75 sticky-top shadow-sm"> 
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-info" href="{{ route('homepage') }}">TOPUP.ID 🎮</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('homepage') }}">Beranda</a>
                </li>
                
                @auth
                    {{-- LINK NAVIGASI UNTUK SEMUA USER YANG LOGIN --}}
                    
                    @if (Auth::user()->role === 0)
                        {{-- User Biasa --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard User</a>
                        </li>
                    @endif

                    @if (Auth::user()->role === 1)
                        {{-- Admin Saja --}}
                        <li class="nav-item">
                            <a class="nav-link fw-bold text-warning" href="{{ route('admin.dashboard') }}">Panel Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('games.index') }}">Kelola Game</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Kelola Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">Kelola Pesanan</a>
                        </li>
                    @endif
                @endauth
            </ul>
          
            
            {{-- User/Logout Dropdown (Pojok Kanan) --}}
            {{-- Tambahkan class d-flex align-items-center pada ul untuk tata letak yang rapi --}}
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                
                {{-- ☀️ DARK MODE TOGGLE (BARU) 🌙 --}}
                {{-- Toggle diposisikan di sebelah kiri tombol Login/Register/Profile --}}
                <li class="nav-item me-3"> 
                    <button class="btn btn-sm btn-outline-info theme-toggle" aria-label="Toggle dark mode">
                        {{-- Ikon awal, akan diganti JS. Default: Bulan (Dark) --}}
                        <span class="theme-icon">🌙</span> 
                    </button>
                </li>
                {{-- END TOGGLE --}}

                @auth
                    {{-- DROP DOWN LOGIN --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    {{-- LINK GUEST (BELUM LOGIN) --}}
                    <li class="nav-item">
                        <a class="btn btn-outline-info me-2" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('register') }}">Daftar</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

{{-- SCRIPT JAVASCRIPT UNTUK FUNGSI DARK MODE --}}
{{-- PENTING: Script ini harus diletakkan setelah tag penutup </nav> --}}
<script>
    (() => {
      // Dapatkan tema yang tersimpan di Local Storage (jika ada)
      const storedTheme = localStorage.getItem('theme');
      
      // Fungsi untuk menentukan tema yang disukai
      const getPreferredTheme = () => {
        if (storedTheme) return storedTheme;
        // Cek preferensi sistem operasi user
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
      }

      // Fungsi untuk mengatur tema dan menyimpan preferensi
      const setTheme = (theme) => {
        // Mengubah atribut data-bs-theme di tag <html>
        document.documentElement.setAttribute('data-bs-theme', theme);
        
        // Mengubah ikon sesuai tema
        const icon = document.querySelector('.theme-icon');
        if (icon) {
            // Jika tema light, tampilkan Bulan (🌙)
            // Jika tema dark, tampilkan Matahari (☀️)
            icon.textContent = theme === 'light' ? '🌙' : '☀️';
        }
      }

      // Terapkan tema saat halaman dimuat
      setTheme(getPreferredTheme());

      // Tambahkan event listener ke tombol toggle setelah DOM selesai dimuat
      document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.querySelector('.theme-toggle');
        if (toggleButton) {
            toggleButton.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                // Simpan preferensi tema baru
                localStorage.setItem('theme', newTheme);
                // Terapkan tema baru
                setTheme(newTheme);
            });
        }
      });
    })()
</script>