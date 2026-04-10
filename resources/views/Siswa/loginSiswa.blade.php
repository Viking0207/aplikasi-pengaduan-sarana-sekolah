<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Siswa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>
<body class="bg-light">
    
    <div class="container" style="margin-top: 7rem;">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6 shadow p-4 bg-success-subtle rounded">
                
                <div class="card mb-4">
                    <div class="card-header bg-success text-white text-center">
                        <h5>Login Siswa</h5>
                    </div>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('siswa.login') }}" method="POST">
                        @csrf

                        @if(session('errorNIS'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-check me-2"></i> {{ session('errorNIS') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="form-floating border border-success rounded mb-3">
                            <input type="text" class="form-control @if(session('error')) is-invalid @endif" id="floatingInput" name="nis" placeholder="NIS" maxlength="9" pattern="[0-9]{9}" required>
                            <label for="floatingInput">NIS</label>
                        </div>

                        <div class="position-relative mb-5">
                            <div class="form-floating border border-success rounded">
                                <input type="password" class="form-control @if(session('error')) is-invalid @endif" id="password" name="pass_siswa" placeholder="Password" maxlength="8" required>
                                <label for="password">Password</label>
                            </div>
                            <button type="button" class="btn btn-link position-absolute top-50 end-0 translate-middle-y me-2 text-success" 
                                    onclick="togglePassword()" style="text-decoration: none; z-index: 10;">
                                <i class="fa-regular fa-eye-slash" id="toggleIcon"></i>
                            </button>
                        </div>
                        
                        <button type="submit" class="btn btn-outline-primary w-100 d-grid">Login</button>
                        
                    </form>
                    
                    <hr class="my-4">

                    <div class="text-center">
                        <a href="/" class="text-decoration-none text-muted"> 
                            <i class="fa-solid fa-arrow-left "></i> Kembali ke home page
                        </a>
                    </div>

                </div>

            </div>
            
            
        </div>
    </div>
</body>

    

</html>