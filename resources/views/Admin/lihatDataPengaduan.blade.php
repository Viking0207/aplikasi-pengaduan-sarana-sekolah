<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lihat & Edit Pengaduan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-light">

    <div class="text-start ms-4 pt-3">
        <h5>
            <a href="{{ route('aspirasi.index') }}" class="text-decoration-none text-info"> 
                <i class="fa-solid fa-angles-left"></i> Kembali 
            </a>
        </h5>
    </div>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-7 shadow p-4 bg-white rounded-4">

                <div class="text-center mb-4 border-bottom pb-3">
                    <h4>Detail & Edit Pengaduan</h4>
                    <p class="text-muted small">Lihat data pengaduan dan update status/feedback</p>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <tr class="table-secondary">
                            <th style="width: 35%">NIS</th>
                            <td>{{ $siswa->nis ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="table-secondary">Kelas</th>
                            <td>{{ $siswa->kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="table-secondary">Kategori</th>
                            <td>{{ $input->kategori->ket_kategori ?? $kategoriTerpilih->ket_kategori ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="table-secondary">Lokasi</th>
                            <td>{{ $input->lokasi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="table-secondary">Keterangan</th>
                            <td>{{ $input->ket ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="table-secondary">Tanggal Pengaduan</th>
                            <td>
                                @if($input && $input->created_at)
                                    {{ \Carbon\Carbon::parse($input->created_at)->isoFormat('DD MMMM YYYY') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="border-top pt-3">

                            <h5 class="mb-3 text-center pb-2">
                                Update Status & Feedback
                            </h5>

                    <form action="{{ route('aspirasi.update', $aspirasi->id_aspirasi ?? $input->id_pelaporan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">
                                <i class="fa-solid fa-flag-checkered text-info me-1"></i> Status Pengaduan
                            </label>
                            <select name="status" id="status" class="form-select border-info" required>
                                <option value="menunggu" {{ ($aspirasi->status ?? 'menunggu') == 'menunggu' ? 'selected' : '' }}>⏳ Menunggu</option>
                                <option value="proses" {{ ($aspirasi->status ?? '') == 'proses' ? 'selected' : '' }}>⚙️ Diproses</option>
                                <option value="selesai" {{ ($aspirasi->status ?? '') == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                <option value="ditolak" {{ ($aspirasi->status ?? '') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="feedback" class="form-label fw-semibold">
                                <i class="fa-solid fa-comment-dots text-info me-1"></i> Feedback / Balasan
                            </label>
                            <textarea class="form-control border-info" id="feedback" name="feedback" 
                                placeholder="Tulis balasan untuk siswa..." 
                                rows="4">{{ old('feedback', $aspirasi->feedback ?? '') }}</textarea>
                            <small class="text-muted">Feedback akan terlihat oleh siswa</small>
                        </div>
                        
                        <button type="submit" class="btn btn-info w-100 py-2 fw-semibold text-white">
                            <i class="fa-solid fa-save me-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
</html>