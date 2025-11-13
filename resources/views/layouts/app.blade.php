{{-- resources/views/layouts/app.blade.php (Layout Baru Bootstrap) --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopUp.ID</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    {{-- resources/views/layouts/app.blade.php (Tambahkan di bagian <head>) --}}
<style>
    /* 1. Atur Body Global */
    html[data-bs-theme="dark"] body {
        background-color: #121212 !important; /* Latar belakang sangat gelap */
        color: #e0e0e0; /* Warna teks terang */
    }

    /* 2. Atur Kartu dan Komponen yang biasanya putih */
    html[data-bs-theme="dark"] .card {
        background-color: #1e1e1e !important;
        color: #e0e0e0 !important;
        border-color: #333 !important;
    }

    /* 3. Atur Tabel (Jika masih ada di view publik) */
    html[data-bs-theme="dark"] .table {
        --bs-table-color: #e0e0e0;
        --bs-table-bg: #1e1e1e;
        --bs-table-border-color: #333;
    }
    
    /* 4. Teks pada input/form */
    html[data-bs-theme="dark"] .form-control {
        background-color: #333;
        color: #e0e0e0;
        border-color: #555;
    }
</style>

</head>
<body class="bg-light"> 

    {{-- Navbar Bootstrap --}}
    @include('layouts.navigation_bs') 

    <main class="container-fluid py-4">
        @yield('content') {{-- Area Konten Admin --}}
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>