<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekapan Laporan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-light">

<div class="container py-4">

    <!-- 🔥 JUDUL -->
    <div class="mb-4">
        <h3 class="fw-bold">Rekapan Laporan Pengaduan</h3>
    </div>

    <!-- 🔍 SEARCH + TAMBAH -->
    <div class="d-flex justify-content-between mb-3">

        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari laporan...">
            <button class="btn btn-primary me-2">Cari</button>
            <a href="#" class="btn btn-secondary">Reset</a>
        </form>

        <a href="#" class="btn btn-success">+ Tambah</a>
    </div>

    <!-- 📊 SUMMARY -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-warning shadow-sm">
                <div class="card-body text-center">
                    Menunggu <br> <strong>10</strong>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success shadow-sm">
                <div class="card-body text-center">
                    Diterima <br> <strong>5</strong>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-danger shadow-sm">
                <div class="card-body text-center">
                    Ditolak <br> <strong>2</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- 📋 TABEL -->
    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Kategori</th>
                        <th>Laporan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    {{-- @forelse($data as $item) --}}
                    <tr>
                        {{-- {{ $loop->iteration }}
                        {{ $item->nama ?? '-' }}
                        {{ $item->kategori ?? '-' }}
                        {{ $item->laporan ?? '-' }} --}}
                        <td>1</td>
                        <td>saya</td>
                        <td>kelas</td>
                        <td>sibaw!!</td>

                        <!-- 🎨 STATUS -->
                        <td>
                            {{-- @if($item->status == 'menunggu') --}}
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            {{-- @elseif($item->status == 'diterima') --}}
                                <span class="badge bg-success">Diterima</span>
                            {{-- @else --}}
                                <span class="badge bg-danger">Ditolak</span>
                            {{-- @endif --}}
                        </td>

                        <td>
                            <a href="#" class="btn btn-sm btn-primary">Detail</a>
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </td>
                    </tr>
                    {{-- @empty --}}
                    <tr>
                        <td colspan="6">Data tidak ada</td>
                    </tr>
                    {{-- @endforelse --}}
                </tbody>

            </table>

        </div>
    </div>

</div>

</body>
</html>

