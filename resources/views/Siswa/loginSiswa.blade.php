<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Siswa</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


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

                        <div class="form-floating border border-success rounded mb-5">
                            <input type="text" class="form-control" id="floatingInput" name="nis" placeholder="Masukkan NIS Anda">
                            <label for="floatingInput">NIS</label>
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