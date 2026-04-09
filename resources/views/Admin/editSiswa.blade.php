<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Siswa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-light">

    <div class="text-start ms-4 pt-3">
        <h5>
            <a href="{{ route('siswa.index') }}" class="text-decoration-none text-info"> 
                <i class="fa-solid fa-angles-left"></i> Kembali
            </a>
        </h5>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 shadow p-4 bg-white rounded">

                <div class="text-center mb-4">
                    <h5>Edit Akun Siswa</h5>
                </div>

                {{-- Form Buat Data Siswa--}}

                    <div class="card-body">
                        <form action="{{ route('siswa.update', $siswa->nis) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-floating border border-info rounded mb-3">
                                <input type="text" class="form-control" id="floatingInput" name="nis" placeholder="NIS (Nomor Induk Siswa)" value="{{ old('nis', $siswa->nis) }}" maxlength="9" pattern="[0-9]{9}" inputmode="numeric" required>
                                <label for="floatingInput">NIS (Nomor Induk Siswa)</label>
                            </div>

                            <div class="form-floating border border-info rounded mb-3">
                                <input type="text" class="form-control" id="floatingInput" name="nama" placeholder="Nama" value="{{ old('nama', $siswa->nama) }}" required>
                                <label for="floatingInput">Nama</label>
                            </div>

                            <div class="form-floating border border-info rounded mb-3">
                                <input type="text" class="form-control" id="floatingInput" name="kelas" placeholder="Kelas" value="{{ $siswa->kelas }}" required>
                                <label for="floatingInput">Kelas</label>
                            </div>

                            <div class="form-floating border border-info rounded mb-5">
                                <input type="password" class="form-control" name="pass_siswa" placeholder="Buat password baru..." maxlength="8" required>
                                <label for="floatingInput">Buat password baru...</label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 d-grid">Edit siswa</button>
            
                        </form>
                    </div>

            </div>
        </div>
    </div>
    
    
</body>
</html>