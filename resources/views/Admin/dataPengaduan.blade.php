<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pengaduan</title>

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

    {{-- Table Data Pengaduan --}}
    
    <div class="container mt-5 mb-5">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif  

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 shadow p-4 bg-info-subtle rounded">

                <div class="bg-info rounded-2 ps-3 py-2 text-start mb-4 border-bottom border-dark-subtle">
                    <h5> <i class="fa-regular fa-message"></i> Tabel Data Pengaduan Siswa</h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="text-center align-middle table-dark">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>NIS</th>
                                <th>Kelas</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                            @forelse($dataFinal as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                
                                {{-- TANGGAL --}}
                                <td class="text-center">
                                    @if(isset($item['input']) && $item['input'])
                                        {{ \Carbon\Carbon::parse($item['input']->created_at)->isoFormat('DD MMM YYYY') ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                
                                {{-- NIS --}}
                                <td class="text-center">
                                    {{ $item['siswa']->nis ?? '-' }}
                                </td>
                                
                                {{-- KELAS --}}
                                <td class="text-center">
                                    {{ $item['siswa']->kelas ?? '-' }}
                                </td>
                                
                                {{-- KATEGORI --}}
                                <td>
                                    {{ $item['kategori']->ket_kategori ?? '-' }}
                                </td>
                                
                                {{-- LOKASI --}}
                                <td>
                                    {{ $item['input']->lokasi ?? '-' }}
                                </td>
                                
                                {{-- KETERANGAN --}}
                                <td>
                                    {{ $item['input']->ket ?? '-' }}
                                </td>
                                
                                {{-- STATUS --}}
                                <td class="text-center">
                                    @php
                                        $status = $item['aspirasi']->status ?? 'menunggu';
                                    @endphp

                                    @if($status == 'menunggu')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($status == 'proses')
                                        <span class="badge bg-info text-white">Diproses</span>
                                    @elseif($status == 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $status }}</span>
                                    @endif  
                                </td>
                                
                                {{-- AKSI --}}
                                <td class="text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <!-- Tombol Lihat/Edit -->
                                        <a href="{{ route('aspirasi.edit.pelaporan', $item['input']->id_pelaporan) }}" class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-eye"></i> Lihat
                                        </a>

                                        {{-- <!-- Tombol Hapus -->
                                        <form action="{{ route('aspirasi.destroy', $item['aspirasi']->id_aspirasi ?? $item['input']->id_pelaporan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                        </form> --}}
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center py-4">
                                        <i class="fa-solid fa-inbox fa-2x text-muted mb-2 d-block"></i>
                                        <span class="text-muted">Belum ada data pengaduan</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</body>
</html>