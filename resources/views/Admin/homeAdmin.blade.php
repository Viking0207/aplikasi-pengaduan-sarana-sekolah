<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <h1>Selamat datang di halaman Admin!</h1>
    <p>kamu login di akun {{ session('admin_username') }}</p>
    @if(session('success'))
        <div class="alert alert-success mb-3" role="alert">
            {{ session('success') }}
        </div>
    @endif
</body>
</html>

