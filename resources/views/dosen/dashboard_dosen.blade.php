<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dashboard Dosen</title>
</head>

<body class="bg-gradient-to-br from-blue-50 via-white to-indigo-50 min-h-screen p-8">

<div class="max-w-6xl mx-auto">

    <!-- Card Utama -->
    <div class="bg-white/80 backdrop-blur rounded-3xl shadow-xl border border-slate-200 p-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">
                    Dashboard Dosen
                </h1>
                <p class="text-slate-500">
                    Selamat datang di sistem penilaian mahasiswa
                </p>
            </div>

            <span class="inline-flex items-center gap-2 text-sm font-semibold bg-indigo-100 text-indigo-700 px-5 py-2 rounded-full shadow">
                📘 Semester Genap 2024
            </span>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

            <div class="rounded-2xl p-6 bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg">
                <p class="text-sm opacity-80">Total Mahasiswa</p>
                <p class="text-4xl font-bold mt-2">
                    {{ count($data) }}
                </p>
            </div>

            <div class="rounded-2xl p-6 bg-gradient-to-br from-emerald-500 to-emerald-600 text-white shadow-lg">
                <p class="text-sm opacity-80">Rata-rata Nilai</p>
                <p class="text-4xl font-bold mt-2">
                    {{ number_format(collect($data)->avg('nilai'), 1) }}
                </p>
            </div>

            <div class="rounded-2xl p-6 bg-gradient-to-br from-violet-500 to-violet-600 text-white shadow-lg">
                <p class="text-sm opacity-80">Mahasiswa Lulus</p>
                <p class="text-4xl font-bold mt-2">
                    {{ collect($data)->where('nilai', '>=', 60)->count() }}
                    <span class="text-lg opacity-80">
                        / {{ count($data) }}
                    </span>
                </p>
            </div>

        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow">
            <table class="min-w-full text-sm rounded-xl overflow-hidden">
                <thead class="bg-slate-100 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold">Nama</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold">Mata Kuliah</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold">Nilai</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                    @foreach($data as $dataku)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 text-slate-600">{{ $dataku['id'] }}</td>
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $dataku['nama'] }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $dataku['matkul'] }}</td>
                        <td class="px-4 py-3 font-semibold text-slate-800">{{ $dataku['nilai'] }}</td>
                        <td class="px-4 py-3">
                            @if($dataku['nilai'] >= 80)
                                <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                    Lulus
                                </span>
                            @elseif($dataku['nilai'] >= 60)
                                <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">
                                    Cukup
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                    Tidak Lulus
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>