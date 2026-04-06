<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a href="#" class="navbar-brand mb-2 h1 fs-4">
                <i class="fa-solid fa-school pt-2"></i> PESALAH - {{ session('admin_username') }}
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="d-flex">
                @csrf
                <button type="submit" class="btn btn-outline-light">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <section class="py-5 bg-light flex-fill d-flex align-content-center" style="height: 89.8vh;">
        <div class="container">
            <div class="row">

                <div class="col-md-12 mb-4">
                    <div class="alert alert-success" >
                        <strong>Selamat datang Masbro!</strong>
                        Anda login sebagai admin dengan username <b>{{ session('admin_username') }}</b>
                    </div>
                </div>

                {{-- CARD BOX 1 --}}
                <div class="col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-bars mb-3"></i>
                            <h5>Kategori</h5>
                                <p class="text-muted">Pilih kategori sarana dan prasarana</p>
                                <a href="#" class="btn btn-primary">Lihat Kategori</a>
                        </div>
                    </div>
                </div>

                {{-- CARD BOX 2 --}}
                <div class="col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-body text-center">
                            <i class="fa-brands fa-rocketchat mb-3"></i>
                            <h5>Data Pengaduan</h5>
                                <p class="text-muted">Lihat pengaduan sarana dan prasarana</p>
                                <a href="#" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>

                {{-- CARD BOX 3 --}}
                <div class="col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-book-bookmark mb-3"></i>
                            <h5>Laporan</h5>
                                <p class="text-muted">Rekap pengaduan</p>
                                <a href="#" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>

                {{-- CARD BOX 4 --}}
                <div class="col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-users mb-3"></i>
                            <h5>Data Siswa</h5>
                                <p class="text-muted">Kelola data siswa di sekolah</p>
                                <a href="{{ route('siswa.index') }}" class="btn btn-primary">Tambah siswa</a>
                        </div>
                    </div>
                </div>
                
                {{-- CARD BOX 5 --}}
                <div class="col-md-4">
                    <div class="card shadow mb-3">
                        <div class="card-body text-center">
                            <i class="fa-solid fa-unlock mb-3"></i>
                            <h5>Akun Admin</h5>
                                <p class="text-muted">Kelola akun admin</p>
                                <a href="#" class="btn btn-primary">Kelola admin</a>
                        </div>
                    </div>
                </div>

                
    </section>


</body>
</html>

