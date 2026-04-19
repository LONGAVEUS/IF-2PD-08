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

@section('title', 'Pengaturan KRS')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Pengaturan KRS</h1>
    <p class="text-gray-500 text-sm">Kelola aturan dan periode pengisian KRS mahasiswa</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h2 class="text-lg font-semibold mb-6 text-gray-700">Form Pengaturan</h2>

        <form class="space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mulai Pengisian</label>
                    <input type="date" class="w-full border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batas Pengisian</label>
                    <input type="date" class="w-full border border-gray-300 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                <input type="text" placeholder="Contoh: Semester Genap 2024/2025" class="w-full border border-gray-300 rounded-xl p-2.5">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Maksimal SKS</label>
                    <input type="number" placeholder="24" class="w-full border border-gray-300 rounded-xl p-2.5">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Minimal IPK</label>
                    <input type="number" step="0.01" placeholder="3.00" class="w-full border border-gray-300 rounded-xl p-2.5">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Sistem</label>
                <select class="w-full border border-gray-300 rounded-xl p-2.5">
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <button type="submit" class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3 rounded-xl shadow-lg shadow-blue-200 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <div class="space-y-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="font-bold text-gray-700 mb-3">Status Saat Ini</h2>
            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                ● KRS Aktif
            </span>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <h2 class="font-bold text-gray-700 mb-3">Ringkasan Aturan</h2>
            <ul class="text-sm text-gray-600 space-y-3">
                <li class="flex items-center gap-2">📌 <b>SKS:</b> Maks 24 SKS</li>
                <li class="flex items-center gap-2">📌 <b>IPK:</b> Minimal 3.00</li>
                <li class="flex items-center gap-2">📌 <b>Mulai:</b> 1 September</li>
            </ul>
        </div>
    </div>
</div>
@endsection


</body>
</html>
