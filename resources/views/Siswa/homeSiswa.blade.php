<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Siswa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <h1>Selamat datang di halaman siswa!</h1>
    <p>kamu login di akun siswa {{ session('siswa_nis') }} kelas {{ $dataSiswa->kelas }}</p>
</body>
</html>

