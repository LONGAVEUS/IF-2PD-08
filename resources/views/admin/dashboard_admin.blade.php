<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Document</title>
</head>
<body>
    @extends('layouts.admin_layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-500">Sistem Pengelolaan KRS & KHS</p>
</div>

<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white p-6 rounded-2xl shadow-lg mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Halo Admin, {{ Auth::user()->name }} 👋</h2>
            <p class="text-blue-100 text-sm">Pantau progres KRS dan nilai mahasiswa dalam satu tampilan terpusat.</p>
        </div>
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="w-20 hidden md:block">
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-700 mb-4">Status Pengisian KRS</h3>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span>Total Mahasiswa</span><span class="font-bold">120</span></div>
            <div class="flex justify-between text-green-600"><span>Sudah Mengisi</span><span class="font-bold">80</span></div>
            <div class="flex justify-between text-red-500"><span>Belum Mengisi</span><span class="font-bold">40</span></div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-700 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 gap-2">
            <a href="{{ route('admin_krs') }}" class="bg-blue-600 text-white text-center py-2.5 rounded-xl hover:bg-blue-700 transition font-semibold">Pengaturan KRS</a>
            <a href="{{ route('admin_khs') }}" class="bg-amber-600 text-white text-center py-2.5 rounded-xl hover:bg-amber-700 transition font-semibold">Pengaturan KHS</a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-700 mb-4">Periode Akademik</h3>
        <div class="text-sm text-gray-600 space-y-2">
            <p>📅 <b>Mulai:</b> 1 September 2026</p>
            <p>🏁 <b>Berakhir:</b> 10 September 2026</p>
            <p>📌 <b>Semester:</b> Ganjil 2026/2027</p>
        </div>
    </div>

</div>

<div class="mt-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
    <h3 class="font-bold text-gray-700 mb-6">Ringkasan Sistem</h3>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-blue-50 p-4 rounded-xl text-center">
            <p class="text-blue-600 font-bold text-2xl">120</p>
            <p class="text-blue-400 text-xs uppercase font-bold">Mahasiswa</p>
        </div>
        <div class="bg-green-50 p-4 rounded-xl text-center">
            <p class="text-green-600 font-bold text-2xl">20</p>
            <p class="text-green-400 text-xs uppercase font-bold">Dosen</p>
        </div>
        <div class="bg-amber-50 p-4 rounded-xl text-center">
            <p class="text-amber-600 font-bold text-2xl">50</p>
            <p class="text-amber-400 text-xs uppercase font-bold">Mata Kuliah</p>
        </div>
    </div>
</div>
@endsection

</body>
</html>
