{{-- resources/views/layouts/app.blade.php (Layout + Navbar Digabung) --}}
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopUp.ID</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* DARK MODE CUSTOM */
        html[data-bs-theme="dark"] body {
            background-color: #121212 !important;
            color: #e0e0e0;
        }
        html[data-bs-theme="dark"] .card {
            background-color: #1e1e1e !important;
            color: #e0e0e0 !important;
            border-color: #333 !important;
        }
        html[data-bs-theme="dark"] .form-control {
            background-color: #333;
            color: #e0e0e0;
            border-color: #555;
        }
        html[data-bs-theme="dark"] .table {
            --bs-table-color: #e0e0e0;
            --bs-table-bg: #1e1e1e;
            --bs-table-border-color: #333;
        }
    </style>
</head>

<body class="bg-light">

{{-- ==================================================================== --}}
{{-- ======================== NAVBAR DIPINDAHKAN ======================== --}}
{{-- ==================================================================== --}}

<nav class="navbar navbar-expand-lg navbar-dark bg-dark bg-opacity-75 sticky-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-info" href="{{ route('homepage') }}">TOPUP.ID 🎮</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('homepage') }}">Beranda</a>
                </li>

                @auth
                    
                    @if (Auth::user()->role === 0)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard User</a>
                        </li>
                    @endif

                    @if (Auth::user()->role === 1)
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

            <ul class="navbar-nav ms-auto d-flex align-items-center">

                {{-- DARK MODE BUTTON --}}
                <li class="nav-item me-3">
                    <button class="btn btn-sm btn-outline-info theme-toggle">
                        <span class="theme-icon">🌙</span>
                    </button>
                </li>

                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold text-white" href="#"
                           id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                           {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
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

{{-- -------------------------------------------------------------------- --}}
{{-- ---------------------------- MAIN CONTENT --------------------------- --}}
{{-- -------------------------------------------------------------------- --}}

<main class="container-fluid py-4">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Script Dark Mode --}}
<script>
(() => {
    const storedTheme = localStorage.getItem('theme');

    const getPreferredTheme = () => {
        if (storedTheme) return storedTheme;
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    const setTheme = (theme) => {
        document.documentElement.setAttribute('data-bs-theme', theme);

        const icon = document.querySelector('.theme-icon');
        if (icon) icon.textContent = theme === 'light' ? '🌙' : '☀️';
    }

    setTheme(getPreferredTheme());

    document.addEventListener('DOMContentLoaded', () => {
        const toggleButton = document.querySelector('.theme-toggle');
        if (toggleButton) {
            toggleButton.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                localStorage.setItem('theme', newTheme);
                setTheme(newTheme);
            });
        }
    });
})();
</script>

</body>
</html>
