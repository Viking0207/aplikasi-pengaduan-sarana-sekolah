<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-light">

    <div class="text-start ms-4 pt-3">
        <h5>
            <a href="{{ route('admin.index') }}" class="text-decoration-none text-info"> 
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
                        <form action="{{ route('admin.update', $admin->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Error Message --}}
                            @if(session('errorPASS'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('errorPASS') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif  

                            <div class="form-floating border border-info rounded mb-3">
                                <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Username" value="{{ old('username', $admin->username) }}" required>
                                <label for="floatingInput">Username</label>
                            </div>

                            <div class="form-floating border border-info rounded mb-5">
                                <input type="password" class="form-control" id="floatingInput" name="password" placeholder="Password" minlength="6" required>
                                <label for="floatingInput">Password</label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 d-grid">Edit admin</button>
            
                        </form>
                    </div>

            </div>
        </div>
    </div>
    
    
</body>
</html>