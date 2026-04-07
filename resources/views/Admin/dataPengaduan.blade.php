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

    {{-- Table Data Siswa --}}
    
    <div class="container mt-5 mb-5">

        @if(@session('aspiDeleted'))
            <div class="alert alert-success">
                {{ session('aspiDeleted') }}
            </div>
        @endif

        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 shadow p-4 bg-info-subtle rounded">

                <div class="bg-info rounded-2 ps-3 py-2 text-start mb-4 border-bottom border-dark-subtle">
                    <h5> <i class="fa-regular fa-message"></i> Tabel Data Siswa</h5>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="text-center border border-dark">
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
                    <tbody class="border border-dark-subtle">
                        @foreach($dataFinal as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $item['input']->tanggal ?? '-' }}</td>
                            <td>{{ $item['siswa']->nis ?? '-' }}</td>
                            <td>{{ $item['siswa']->kelas ?? '-' }}</td>
                            <td>{{ $item['kategori']->ket_kategori ?? '-' }}</td>
                            <td>{{ $item['input']->lokasi ?? '-' }}</td>
                            <td>{{ $item['input']->ket ?? '-' }}</td>
                            <td class="text-center">
                                @php
                                    $status = $item['aspirasi']->status ?? '-';
                                @endphp

                                @if ($status == 'menunggu')
                                    <span class="badge bg-danger">Menunggu</span>
                                @elseif($status == 'proses')
                                    <span class="badge bg-warning">Proses</span>
                                @elseif($status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <!-- Tombol Lihat -->
                                <a href="{{ route('aspirasi.edit', $item['aspirasi']->id_aspirasi) }}" class="btn btn-sm btn-primary">Lihat</a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('aspirasi.destroy', $item['aspirasi']->id_aspirasi) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</body>
</html>