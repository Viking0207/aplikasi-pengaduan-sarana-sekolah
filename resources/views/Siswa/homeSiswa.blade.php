<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Siswa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a href="#" class="navbar-brand mb-2 h1 fs-4">
                <i class="fa-solid fa-graduation-cap"></i> PESALAH - {{ session('siswa_kelas') }}
            </a>

            <form action="{{ route('siswa.logout') }}" method="POST" class="d-flex">
                @csrf

                <h5 class="justify-content-end text-light me-3 pt-2">
                    NIS: <span class="badge bg-info-subtle text-dark">{{ session('siswa_nis') }}</span>
                </h5>

                <button type="submit" class="btn btn-outline-light">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </nav>

<div class="container py-4">
    

    <!-- 🔥 JUDUL -->
    <h3 class="mb-4 fw-bold">Pengaduan Sarana Sekolah</h3>

    <!-- ✅ ALERT -->
    @if(session('siswaLogin'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('siswaLogin') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- 📩 FORM PENGADUAN -->
            <div class="card mb-4 shadow-md">
                <div class="card-header bg-primary text-white">
                    Form Pengaduan
                </div>
        
                <div class="card-body">
                    <form action="{{ route('forum.store') }}" method="POST">
                        @csrf
        
                        <!-- KATEGORI -->
                        <div class="mb-3">
                            <label class="form-label"> <i class="fa-solid fa-tag text-primary me-1"></i> Kategori:</label>
                            <select name="id_kategori" class="form-select mb-2">
                                <option value="">-- pilih kategori --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id_kategori }}">{{ $k->ket_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> <i class="fa-solid fa-location-dot text-primary me-1"></i> Lokasi:</label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Ruang Kelas X RPL 1, Laboratorium, Perpustakaan, dll." required>
                        </div>
        
                        <!-- ISI LAPORAN -->
                        <div class="mb-3">
                            <label class="form-label"> <i class="fa-solid fa-message text-primary me-1"></i> Isi Pengaduan:</label>
                            <textarea name="ket" class="form-control" rows="3" placeholder="Contoh: Kursi rusak di kelas..." required></textarea>
                        </div>
        
                        <button class="btn btn-success"><i class="fa-solid fa-paper-plane me-1"></i> <strong class="me-1">Kirim</strong> </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- 📋 HISTORI -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            Histori Pengaduan
        </div>

        <div class="card-body">

            <table class="table table-bordered table-hover text-center align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th> 
                        <th>Kategori</th>
                        <th>Pengaduan</th>
                        <th>Status</th>
                        <th>Balasan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($dataInput as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $item->created_at ? $item->created_at->isoFormat('DD MMMM YYYY') : '-' }}
                        </td>
                        <td>{{ $item->kategori->ket_kategori ?? '-' }}</td>
                        <td>{{ $item->lokasi }} - {{ $item->ket }}</td>
                        <td>
                            {{-- STATUS dari tabel aspirasi --}}
                            @if($item->aspirasi && $item->aspirasi->status == 'proses')
                                <span class="badge bg-info">Diproses</span>
                            @elseif($item->aspirasi && $item->aspirasi->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($item->aspirasi && $item->aspirasi->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @endif
                        </td>
                        <td>
                            {{-- FEEDBACK dari tabel aspirasi --}}
                            @if($item->aspirasi && $item->aspirasi->feedback)
                                <span class="text-success">{{ $item->aspirasi->feedback }}</span>
                            @else
                                <span class="text-muted">Belum ada balasan</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if(!$item->aspirasi || $item->aspirasi->status == 'menunggu')
                                <a href="{{ route('forum.edit', $item->id_pelaporan) }}" class="btn btn-sm btn-primary">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('forum.destroy', $item->id_pelaporan) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">
                                    <i class="fa-solid fa-lock"></i> Tidak bisa diubah
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada pengaduan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>