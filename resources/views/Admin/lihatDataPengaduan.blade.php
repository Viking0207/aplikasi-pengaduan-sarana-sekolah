<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lihat Pengaduan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-light">

    {{-- {{ dd($siswa->toArray()) }} --}}

    <div class="text-start ms-4 pt-3">
        <h5>
            <a href="{{ route('aspirasi.index') }}" class="text-decoration-none text-info"> 
                <i class="fa-solid fa-angles-left"></i> Kembali
            </a>
        </h5>
    </div>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 shadow p-4 bg-white rounded">

                <div class="text-start mb-4">
                    <h5>Lihat Data Pengaduan</h5>
                </div>

                
                
                {{-- Tabel Data Pengaduan --}}
                <table class="table table-bordered">
                    <tr>
                        <th>NIS</th>
                        <td>{{ $siswa->nis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $siswa->kelas ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $kategori->ket_kategori ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $input->lokasi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Keterangan</th>
                        <td>{{ $input->ket ?? '-' }}</td>
                    </tr>
                </table>

                {{-- Form Buat Data Siswa--}}
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Error Message --}}
                        @if(@session('errorPASS'))
                        <div class="alert alert-danger">
                            {{ session('errorPASS') }}
                        </div>
                        @endif

                        <div class="form-floating mb-3">
                            <select name="status" id="status" class="form-select" required>
                                <option value="menunggu" {{ $aspirasi->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ $aspirasi->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $aspirasi->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            <label for="status">Status Pengaduan</label>
                        </div>
                        
                        <div class="form-floating mb-5">
                            <textarea class="form-control" id="feedback" name="feedback" placeholder="Feedback" style="height: 8rem">{{ old('feedback', $aspirasi->feedback) }}</textarea>
                            <label for="floatingInput">Feedback</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 d-grid">Edit admin</button>
                        
                    </form>
                </div>

            </div>
        </div>
    </div>
    
</body>
</html>