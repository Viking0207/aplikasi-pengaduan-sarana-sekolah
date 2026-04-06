<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Admin</title>

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
            <div class="col-md-6 shadow mb-5 p-4 bg-info-subtle rounded">

                <div class="text-center mb-4">
                    <h5>Kelola Akun Admin</h5>
                </div>

                {{-- Form Buat Data Siswa--}}

                <div class="card-body">
                    <form action="{{ route('admin.store') }}" method="POST">
                        @csrf

                        {{-- Success Message --}}
                        @if(@session('adminSuccess'))
                            <div class="alert alert-success">
                                {{ session('adminSuccess') }}
                            </div>
                        @endif

                        @if(@session('updateSuccess'))
                            <div class="alert alert-success">
                                {{ session('updateSuccess') }}
                            </div>
                        @endif

                        {{-- Error Message --}}
                        @if(@session('errorPASS'))
                            <div class="alert alert-danger">
                                {{ session('errorPASS') }}
                            </div>
                        @endif

                        <div class="form-floating border border-info rounded mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Username" required>
                            <label for="floatingInput">Username</label>
                        </div>

                        <div class="form-floating border border-info rounded mb-5">
                            <input type="password" class="form-control" id="floatingInput" name="password" placeholder="Password" minlength="6" required>
                            <label for="floatingInput">Password</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 d-grid">Tambah admin</button>
        
                    </form>
                </div>
                
                {{-- Table Data Admin --}}
                
                <div class="container mt-5 mb-5">
            
                    @if(@session('adminDeleted'))
                        <div class="alert alert-success">
                            {{ session('adminDeleted') }}
                        </div>
                    @endif
            
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12 shadow p-4 bg-white rounded">
            
                            <div class="text-center mb-4 border-bottom border-dark-subtle">
                                <h5>Tabel Data Admin</h5>
                            </div>
            
                            <table class="table table-bordered table-striped">
                                <thead class="text-center border border-dark">
                                    <tr>
                                        <th>Username</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="border border-dark-subtle">
                                    @foreach($dataAdmin as $admin)
                                    <tr>
                                        <td>{{ $admin->username }}</td>
                                        <td class="text-center">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-sm btn-primary">Edit</a>
            
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" style="display: inline-block;">
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
    </div>

    
    



    
    
</body>
</html>