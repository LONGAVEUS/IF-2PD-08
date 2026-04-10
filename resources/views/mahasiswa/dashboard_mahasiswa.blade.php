<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dashboard Mahasiswa</title>
</head>
<body>
    @extends('layouts.mahasiswa_layout')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Halo, Selamat Datang di Dashboard!</h5>
        <p class="font-normal text-gray-700 dark:text-gray-400">Ini adalah contoh konten yang masuk ke dalam @yield('content').</p>
    </div>
@endsection

</body>
</html>
