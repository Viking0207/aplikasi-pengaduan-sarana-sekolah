<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Siswa</title>

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

    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 shadow p-4 bg-info-subtle rounded">

                <div class="text-center mb-4">
                    <h5>Tambah Akun Siswa</h5>
                </div>

                {{-- Form Buat Data Siswa--}}

                <div class="card-body">
                    <form action="{{ route('siswa.store') }}" method="POST">
                        @csrf

                        {{-- Success Message --}}
                        @if(session('inputSuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-check me-2"></i> {{ session('inputSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif  

                        {{-- Error Message --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-floating border border-info rounded mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="nis" placeholder="NIS (Nomor Induk Siswa)" maxlength="9" pattern="[0-9]{9}" required>
                            <label for="floatingInput">NIS (Nomor Induk Siswa)</label>
                        </div>

                        <div class="form-floating border border-info rounded mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="nama" placeholder="Nama" required>
                            <label for="floatingInput">Nama</label>
                        </div>

                        <div class="form-floating border border-info rounded mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="kelas" placeholder="Kelas" required>
                            <label for="floatingInput">Kelas</label>
                        </div>

                        <div class="form-floating border border-info rounded mb-5">
                            <input type="password" class="form-control" id="floatingInput" name="pass_siswa" placeholder="Password" maxlength="8" required>
                            <label for="floatingInput">Password</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 d-grid">Tambah siswa</button>
        
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    
    {{-- Table Data Siswa --}}
    
    <div class="container mt-5 mb-5">

        @if(@session('siswaDeleted'))
            <div class="alert alert-success">
                {{ session('siswaDeleted') }}
            </div>
        @endif

        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 shadow p-4 bg-info-subtle rounded">

                <div class="text-center mb-4 border-bottom border-dark-subtle">
                    <h5>Tabel Data Siswa</h5>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="text-center border border-dark">
                        <tr>
                            <th>NIS (Nomor Induk Siswa)</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border border-dark-subtle">
                        @foreach($dataSiswa as $siswa)
                        <tr>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->kelas }}</td>
                            <td class="text-center">
                                <a href="{{ route('siswa.edit', $siswa->nis) }}" class="btn btn-sm btn-primary">Edit</a>

                                <form action="{{ route('siswa.destroy', $siswa->nis) }}" method="POST" style="display: inline-block;">
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