<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

<!-- HEADER -->
<div class="mb-6">
    <h1 class="text-3xl font-bold">Dashboard Admin</h1>
    <p class="text-gray-500">Sistem Pengelolaan KRS & KHS</p>
</div>

<!-- STATISTIK -->
<div class="grid grid-cols-4 gap-4 mb-6">

    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Mahasiswa</p>
        <h2 class="text-3xl font-bold text-blue-600">120</h2>
    </div>

    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Dosen</p>
        <h2 class="text-3xl font-bold text-green-600">20</h2>
    </div>

    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Mata Kuliah</p>
        <h2 class="text-3xl font-bold text-purple-600">50</h2>
    </div>

    <div class="bg-white p-5 rounded-xl shadow">
        <p class="text-gray-500">Status KRS</p>
        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
            Aktif
        </span>
    </div>

</div>

<!-- MAIN GRID -->
<div class="grid grid-cols-3 gap-6">

    <!-- STATUS KRS -->
    <div class="bg-white p-5 rounded-xl shadow col-span-1">
        <h2 class="font-semibold mb-4">Status Pengisian KRS</h2>

        <div class="space-y-2 text-sm text-gray-700">
            <p>Total Mahasiswa: <b>120</b></p>
            <p>Sudah Mengisi: <b class="text-green-600">80</b></p>
            <p>Belum Mengisi: <b class="text-red-600">40</b></p>
        </div>

        <div class="mt-4 bg-yellow-100 text-yellow-800 p-3 rounded-lg text-sm">
            ⚠️ 40 mahasiswa belum mengisi KRS
        </div>
    </div>

    <!-- QUICK ACTION -->
    <div class="bg-white p-5 rounded-xl shadow col-span-1">
        <h2 class="font-semibold mb-4">Quick Action</h2>

        <div class="space-y-2">
            <a href="/admin/krs"
               class="block bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700">
                Pengaturan KRS
            </a>

            <a href="/admin/krs"
               class="block bg-yellow-600 text-white text-center py-2 rounded-lg hover:bg-yellow-700">
                Pengaturan KHS
            </a>

            <button class="block w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">
                Lihat laporan
            </button>
        </div>
    </div>

    <!-- INFO PERIODE -->
    <div class="bg-white p-5 rounded-xl shadow col-span-1">
        <h2 class="font-semibold mb-4">Periode KRS</h2>

        <ul class="text-sm text-gray-600 space-y-1">
            <li>📅 Mulai: 1 September</li>
            <li>📅 Berakhir: 10 September</li>
            <li>📌 Semester: Genap 2024/2025</li>
        </ul>
    </div>

</div>

<div class="bg-white p-5 rounded-xl shadow mt-6">

    <h2 class="font-semibold mb-4">Ringkasan Sistem</h2>

    <div class="grid grid-cols-3 gap-4 text-sm">

        <!-- Mahasiswa -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-500">Mahasiswa</p>
            <p class="font-bold text-lg">120</p>
            <p class="text-green-600 text-xs">115 Aktif</p>
        </div>

        <!-- Dosen -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-500">Dosen</p>
            <p class="font-bold text-lg">20</p>
            <p class="text-gray-600 text-xs">15 Dosen Wali</p>
        </div>

        <!-- Mata Kuliah -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="text-gray-500">Mata Kuliah</p>
            <p class="font-bold text-lg">50</p>
            <p class="text-gray-600 text-xs">Total SKS: 120</p>
        </div>

    </div>

    <!-- KRS Status -->
    <<div class="grid grid-cols-3 gap-4 mt-4 text-sm">

    <!-- MAHASISWA -->
    <div class="bg-blue-50 p-4 rounded-lg">
        <p class="font-medium">Status KRS</p>
        <p>✔ 80 mahasiswa sudah mengisi</p>
        <p>⚠️ 40 mahasiswa belum mengisi</p>
    </div>

    <!-- DOSEN -->
    <div class="bg-green-50 p-4 rounded-lg">
        <p class="font-medium">Input Nilai Dosen</p>
        <p>✔ 40 mata kuliah sudah dinilai</p>
        <p>⚠️ 10 mata kuliah belum dinilai</p>
    </div>

    <!-- MATA KULIAH -->
    <div class="bg-yellow-50 p-4 rounded-lg">
        <p class="font-medium">Kesiapan Mata Kuliah</p>
        <p>✔ 45 matkul sudah ada dosen</p>
        <p>⚠️ 5 matkul belum ada dosen</p>
    </div>

</div>