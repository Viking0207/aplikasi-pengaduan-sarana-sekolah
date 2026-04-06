<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PESALAH - Sistem Pengaduan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand mb-2 h1 fs-4">
                <i class="fa-solid fa-school pt-2"></i> PESALAH
            </span>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-5 bg-light flex-fill d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-md-6 mb-4">
                    <h1 class="fw-bold">Sistem Pengaduan Sarana Sekolah</h1>
                    <p class="text-muted">
                        Aplikasi ini digunakan untuk memudahkan siswa dalam menyampaikan
                        pengaduan terkait sarana sekolah yang rusak atau tidak berfungsi.
                    </p>

                    <a href="{{ route('loginAdmin') }}" class="btn btn-outline-primary me-2">
                        <i class="fa-solid fa-user-tie"></i> Login Admin
                    </a>

                    <a href="{{ route('loginSiswa') }}" class="btn btn-success">
                        <i class="fa-solid fa-user-graduate"></i> Login Siswa
                    </a>
                </div>

                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body text-center">

                            <i class="fa-solid fa-comments fa-3x text-primary mb-3"></i>

                            <h5 class="card-title fw-bold">
                                Pengaduan | Umpan Balik | Progres
                            </h5>

                            <p class="text-muted">
                                Setiap laporan akan ditindaklanjuti oleh pihak sekolah.
                            </p>

                            <hr>

                            <small class="d-block fw-bold">
                                UKK RPL 2026
                            </small>

                            <small class="text-primary">
                                By: Ficky Febryan Saputra
                            </small>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-secondary text-center text-white py-3 mt-auto">
        <small>&copy; PESALAH - UKK RPL 2026</small>
    </footer>

</body>
</html>