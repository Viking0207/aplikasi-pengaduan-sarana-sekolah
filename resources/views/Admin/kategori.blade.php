<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kategori</title>

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
        <div class="row justify-content-center">
            <div class="col-md-12 ">

                @if(session('katDeleted'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('katDeleted') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('ekSuccess'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i> {{ session('ekSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="card shadow">

                    <div class="card-header bg-info text-dark text-opacity-75">
                        <h5> <i class="fa-solid fa-bars"></i> Kategori</h5>
                    </div>

                    <div class="card-body bg-info-subtle">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            
                            <form action="{{ route('kategori.search') }}" method="GET" class="d-flex">

                                <a href="{{ route('kategori.index') }}" class="btn btn-info me-2">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                </a>

                                <input type="text" name="search" class="form-control me-2" placeholder="Cari status..." value="">

                                <button type="submit" class="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>

                            <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah"> + Tambah Data</a>
                        </div>

                        <table class="table table-bordered table-striped">
                            <thead class="text-center border border-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="border border-dark-subtle">
                                @foreach($dataKategori as $kategori)
                                <tr class="text-center">
                                    
                                    <td>({{ $loop->iteration }})</td>
                                    <td>{{ $kategori->ket_kategori }}</td>
                                    <td>
                                        <!-- Tombol Lihat -->
                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $kategori->id_kategori }}">Lihat</a>
        
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('kategori.destroy', $kategori->id_kategori) }}" method="POST" style="display: inline-block;">
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
        </div>
    </div>

    {{-- Modal Tambah Kategori --}}

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    
                    <div class="modal-body">
                        <input type="text" name="ket_kategori" class="form-control" placeholder="Tambahkan Kategori..." required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Modal edit Kategori --}}

    @foreach($dataKategori as $item)
    <div class="modal fade" id="modalEdit{{ $item->id_kategori }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('kategori.update', $item->id_kategori) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="modal-body">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="ket_kategori" class="form-control" value="{{ $item->ket_kategori }}" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @endforeach

</body>
</html>