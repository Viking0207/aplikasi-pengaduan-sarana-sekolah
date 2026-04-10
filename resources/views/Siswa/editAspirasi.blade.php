<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Pengaduan | Sistem Aspirasi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">

    <div class="text-start ms-4 pt-3">
        <h5>
            <a href="{{ route('forum.index') }}" class="text-decoration-none text-info">
                <i class="fa-solid fa-angles-left"></i> Kembali
            </a>
        </h5>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">

                <div class="card shadow border-0 rounded-5">
                    <div class="card-header bg-white border-0 rounded-5 pt-4 pb-2">
                        <div class="text-center">
                            <h4 class="mb-1">Edit Pengaduan</h4>
                            <p class="text-muted small">Perbarui data pengaduan Anda di bawah ini</p>
                        </div>
                    </div>

                    <div class="card-body px-4 pb-4">

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

                        <form action="{{ route('forum.update', $aspirasi->id_pelaporan) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="kategori" class="form-label fw-semibold">
                                    <i class="fa-solid fa-tag text-info me-1"></i> Kategori Pengaduan
                                </label>
                                <select class="form-select border-info" id="kategori" name="id_kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategori as $k)
                                        <option value="{{ $k->id_kategori }}" 
                                            {{ $aspirasi->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                                            {{ $k->ket_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="lokasi" class="form-label fw-semibold">
                                    <i class="fa-solid fa-location-dot text-info me-1"></i> Lokasi
                                </label>
                                <input type="text" class="form-control border-info" id="lokasi" 
                                    name="lokasi" placeholder="Contoh: Ruang Kelas X RPL 1" 
                                    value="{{ old('lokasi', $aspirasi->lokasi) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="ket" class="form-label fw-semibold">
                                    <i class="fa-solid fa-message text-info me-1"></i> Isi Pengaduan
                                </label>
                                <textarea class="form-control border-info" id="ket" 
                                    name="ket" placeholder="Jelaskan pengaduan Anda..." 
                                    style="height: 130px" required>{{ old('ket', $aspirasi->ket) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-info w-100 py-2 fw-semibold text-white">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Update Pengaduan
                            </button>

                            <div class="text-center mt-4">
                                <small class="text-muted">
                                    <i class="fa-solid fa-info-circle me-1"></i> 
                                    Pengaduan yang sudah diproses tidak dapat diedit
                                </small>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>