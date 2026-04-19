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
    <div class="p-8 bg-white/80 backdrop-blur border border-gray-200 rounded-2xl shadow-xl dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h5 class="text-3xl font-bold tracking-tight text-indigo-900 dark:text-white">
                    Halo, Selamat Datang di Dashboard!
                </h5>
                <p class="mt-2 text-lg text-gray-600 dark:text-gray-400">
                    Selamat beraktivitas kembali, <span class="font-bold text-indigo-600">{{ Auth::user()->name }}</span>
                </p>
            </div>
            <div class="p-3 bg-indigo-50 rounded-full shadow-inner">
                <span class="text-2xl">🎓</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <div class="p-6 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl text-white shadow-lg">
                <p class="text-sm opacity-80">Status Akademik</p>
                <p class="text-2xl font-bold mt-1">Aktif</p>
            </div>
            <div class="p-6 bg-white border border-gray-100 rounded-xl shadow-sm">
                <p class="text-sm text-gray-500">Semester Saat Ini</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">Semester 2</p>
            </div>
        </div>
    </div>
@endsection

</body>
</html>
