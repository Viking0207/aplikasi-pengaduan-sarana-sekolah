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

    <div class="text-start ms-4 pt-3">
        <h5>
            <a href="{{ route('admin.homeAdmin') }}" class="text-decoration-none text-info"> 
                <i class="fa-solid fa-angles-left"></i> Kembali
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
                        <h2 class="mb-0">{{ $statistik['total'] ?? 0 }}</h2>
                        <small>Seluruh histori</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark shadow">
                    <div class="card-body">
                        <h5 class="card-title">Diproses</h5>
                        <h2 class="mb-0">{{ $statistik['proses'] ?? 0 }}</h2>
                        <small>Status proses</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Selesai</h5>
                        <h2 class="mb-0">{{ $statistik['selesai'] ?? 0 }}</h2>
                        <small>Status selesai</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        <h5 class="card-title">Hari Ini</h5>
                        <h2 class="mb-0">{{ $statistik['hari_ini'] ?? 0 }}</h2>
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
                {{-- Overflow auto untuk scroll horizontal --}}
                <div style="overflow-x: auto; white-space: nowrap;">
                    <form action="{{ route('rekapan.filter') }}" method="GET" style="min-width: 900px;">
                        <div class="row g-3 align-items-end">
                            
                            {{-- Pilihan Jenis Filter --}}
                            <div class="col-md-2">
                                <label class="form-label">Filter Berdasarkan</label>
                                <select name="filter_type" class="form-select" onchange="this.form.submit()">
                                    <option value="tanggal" {{ request('filter_type') == 'tanggal' || !request('filter_type') ? 'selected' : '' }}>📅 Per Tanggal</option>
                                    <option value="bulan" {{ request('filter_type') == 'bulan' ? 'selected' : '' }}>📆 Per Bulan</option>
                                </select>
                            </div>

                            {{-- FILTER PER TANGGAL (Range Date) --}}
                            @if(request('filter_type') != 'bulan')
                            <div class="col-md-5">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label">Dari Tanggal</label>
                                        <input type="date" name="start_date" class="form-control" 
                                            value="{{ old('start_date', request('start_date')) }}"
                                            max="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Sampai Tanggal</label>
                                        <input type="date" name="end_date" class="form-control" 
                                            value="{{ old('end_date', request('end_date')) }}"
                                            max="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                {{-- Pesan error jika tanggal melebihi hari ini --}}
                                @php
                                    $startError = request('start_date') && request('start_date') > date('Y-m-d');
                                    $endError = request('end_date') && request('end_date') > date('Y-m-d');
                                @endphp
                                @if($startError || $endError)
                                    <small class="text-danger d-block mt-1">
                                        ⚠️ Tanggal tidak boleh melebihi hari ini ({{ date('d/m/Y') }})
                                    </small>
                                @endif
                            </div>
                            @endif

                            {{-- FILTER PER BULAN --}}
                            @if(request('filter_type') == 'bulan')
                            <div class="col-md-5">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label">Pilih Tahun</label>
                                        <select name="tahun" class="form-select">
                                            @php
                                                $currentYear = date('Y');
                                                $selectedYear = request('tahun', $currentYear);
                                            @endphp
                                            @for($year = $currentYear - 5; $year <= $currentYear; $year++)
                                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Pilih Bulan</label>
                                        <select name="bulan" class="form-select">
                                            <option value="semua" {{ request('bulan') == 'semua' || !request('bulan') ? 'selected' : '' }}>Semua Bulan</option>
                                            <option value="01" {{ request('bulan') == '01' ? 'selected' : '' }}>Januari</option>
                                            <option value="02" {{ request('bulan') == '02' ? 'selected' : '' }}>Februari</option>
                                            <option value="03" {{ request('bulan') == '03' ? 'selected' : '' }}>Maret</option>
                                            <option value="04" {{ request('bulan') == '04' ? 'selected' : '' }}>April</option>
                                            <option value="05" {{ request('bulan') == '05' ? 'selected' : '' }}>Mei</option>
                                            <option value="06" {{ request('bulan') == '06' ? 'selected' : '' }}>Juni</option>
                                            <option value="07" {{ request('bulan') == '07' ? 'selected' : '' }}>Juli</option>
                                            <option value="08" {{ request('bulan') == '08' ? 'selected' : '' }}>Agustus</option>
                                            <option value="09" {{ request('bulan') == '09' ? 'selected' : '' }}>September</option>
                                            <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober</option>
                                            <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November</option>
                                            <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Status --}}
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="semua">Semua Status</option>
                                    <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            
                            <div class="col-md-2">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                                    </button>
                                    <a href="{{ route('rekapan.index') }}" class="btn btn-secondary w-100">
                                        <i class="fa-solid fa-rotate-right"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
                                <th>Komentar</th>
                                <th>Status</th>
                                <th>Feedback Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($histori ?? [] as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal_update)->isoFormat('DD MMM YYYY') }}
                                </td>
                                <td class="text-center">{{ $item->nis ?? '-' }}</td>
                                <td>
                                    <div class="text-start">
                                        <strong>Lokasi:</strong> {{ $item->aspirasi->inputAspirasi->lokasi ?? '-' }}<br>
                                        <strong>Isi:</strong> {{ $item->aspirasi->inputAspirasi->ket ?? '-' }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if(($item->status ?? '') == 'proses')
                                        <span class="badge bg-warning text-dark">Proses</span>
                                    @elseif(($item->status ?? '') == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif(($item->status ?? '') == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item->status ?? 'Menunggu' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->feedback)
                                        <div class="text-start">
                                            <i class="fa-solid fa-comment-dots text-info me-1"></i> 
                                            {{ $item->feedback }}
                                        </div>
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
                        <tfoot class="table-light">
                            <tr>
                                <td colspan="7" class="text-end">
                                    <strong>Total Data: {{ isset($histori) ? $histori->count() : 0 }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

    

</html>