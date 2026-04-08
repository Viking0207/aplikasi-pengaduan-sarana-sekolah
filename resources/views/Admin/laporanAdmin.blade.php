<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekapan Laporan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <div class="text-start ms-4 pt-3">
        <h5>
            <a href="{{ route('admin.homeAdmin') }}" class="text-decoration-none text-info"> 
                <i class="fa-solid fa-angles-left"></i> Kembali ke Dashboard
            </a>
        </h5>
    </div>

    <div class="container mt-4 mb-5">
        
        {{-- JUDUL --}}
        <div class="text-center mb-4">
            <h3 class="fw-bold">
                <i class="fa-solid fa-chart-line text-info me-2"></i> 
                Rekapan Histori Aspirasi
            </h3>
            <p class="text-muted">Catatan aktivitas perubahan status dan feedback admin</p>
        </div>

        {{-- STATISTIK CARD --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Total Aktivitas</h5>
                        <h2 class="mb-0">{{ $statistik['total'] }}</h2>
                        <small>Seluruh histori</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark shadow">
                    <div class="card-body">
                        <h5 class="card-title">Diproses</h5>
                        <h2 class="mb-0">{{ $statistik['proses'] }}</h2>
                        <small>Status proses</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Selesai</h5>
                        <h2 class="mb-0">{{ $statistik['selesai'] }}</h2>
                        <small>Status selesai</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Hari Ini</h5>
                        <h2 class="mb-0">{{ $statistik['hari_ini'] }}</h2>
                        <small>Aktivitas hari ini</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- FILTER --}}
        <div class="card shadow mb-4">
            <div class="card-header bg-dark text-white">
                <i class="fa-solid fa-filter me-2"></i> Filter Data
            </div>
            <div class="card-body">
                <form action="{{ route('rekapan.filter') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="semua">Semua</option>
                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABEL REKAPAN --}}
        <div class="card shadow">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-table-list me-2"></i> Data Histori</span>
                <a href="{{ route('rekapan.export') }}" class="btn btn-sm btn-success">
                    <i class="fa-solid fa-download me-1"></i> Export CSV
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-secondary text-center">
                            <tr>
                                <th>No</th>
                                <th>Tanggal Update</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>ID Aspirasi</th>
                                <th>Status</th>
                                <th>Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($histori as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal_update)->isoFormat('DD MMM YYYY, HH:mm') }}
                                </td>
                                <td class="text-center">{{ $item->nis ?? '-' }}</td>
                                <td>{{ $item->siswa->nama ?? '-' }}</td>
                                <td class="text-center">{{ $item->id_aspirasi ?? '-' }}</td>
                                <td class="text-center">
                                    @if($item->status == 'proses')
                                        <span class="badge bg-info">Diproses</span>
                                    @elseif($item->status == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->feedback)
                                        <i class="fa-solid fa-comment-dots text-info me-1"></i> {{ $item->feedback }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fa-solid fa-inbox fa-2x text-muted mb-2 d-block"></i>
                                        <span class="text-muted">Belum ada data histori</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>