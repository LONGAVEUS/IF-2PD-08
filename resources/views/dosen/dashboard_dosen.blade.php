<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dashboard Dosen</title>
</head>
<body>
   @extends('layouts.dosen_layout')

@section('content')
    <div class="max-w-6xl mx-auto">

        <div class="bg-white/80 backdrop-blur rounded-3xl shadow-xl border border-indigo-100 p-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-indigo-900 tracking-tight">
                        Dashboard Dosen
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Selamat datang di sistem penilaian mahasiswa
                    </p>
                </div>

                <span class="inline-flex items-center gap-2 text-sm font-semibold bg-indigo-100 text-indigo-700 px-5 py-2 rounded-full shadow">
                    📘 Semester Genap 2024
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="rounded-2xl p-6 bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30">
                    <p class="text-sm opacity-80">Total Mahasiswa</p>
                    <p class="text-4xl font-bold mt-2">
                        {{ count($data) }}
                    </p>
                </div>

                <div class="rounded-2xl p-6 bg-gradient-to-br from-emerald-500 to-emerald-600 text-white shadow-lg shadow-emerald-500/30">
                    <p class="text-sm opacity-80">Rata-rata Nilai</p>
                    <p class="text-4xl font-bold mt-2">
                        {{ number_format(collect($data)->avg('nilai'), 1) }}
                    </p>
                </div>

                <div class="rounded-2xl p-6 bg-gradient-to-br from-violet-500 to-violet-600 text-white shadow-lg shadow-violet-500/30">
                    <p class="text-sm opacity-80">Mahasiswa Lulus</p>
                    <p class="text-4xl font-bold mt-2">
                        {{ collect($data)->where('nilai', '>=', 60)->count() }}
                        <span class="text-lg opacity-80">
                            / {{ count($data) }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border-2 border-indigo-50 bg-white shadow-lg shadow-indigo-500/5">
                <table class="min-w-full text-sm rounded-xl overflow-hidden text-left">
                    <thead class="bg-indigo-50/50">
                        <tr>
                            <th class="px-5 py-4 text-xs font-semibold tracking-wider uppercase text-indigo-800 border-b-2 border-indigo-100">ID</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-wider uppercase text-indigo-800 border-b-2 border-indigo-100">Nama</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-wider uppercase text-indigo-800 border-b-2 border-indigo-100">Mata Kuliah</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-wider uppercase text-indigo-800 border-b-2 border-indigo-100">Nilai</th>
                            <th class="px-5 py-4 text-xs font-semibold tracking-wider uppercase text-indigo-800 border-b-2 border-indigo-100">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-indigo-50">
                        @foreach($data as $dataku)
                        <tr class="hover:bg-indigo-50/30 transition">
                            <td class="px-5 py-4 align-middle">
                                <span class="text-xs font-semibold text-white bg-indigo-500 rounded-md px-2.5 py-1 tracking-wide">{{ $dataku['id'] }}</span>
                            </td>
                            <td class="px-5 py-4 align-middle font-semibold text-gray-800">{{ $dataku['nama'] }}</td>
                            <td class="px-5 py-4 align-middle text-gray-600">{{ $dataku['matkul'] }}</td>
                            <td class="px-5 py-4 align-middle font-bold text-indigo-700">{{ $dataku['nilai'] }}</td>
                            <td class="px-5 py-4 align-middle">
                                @if($dataku['nilai'] >= 80)
                                    <span class="px-3 py-1.5 text-xs font-semibold bg-teal-100 text-teal-700 rounded-full inline-block">
                                        Lulus
                                    </span>
                                @elseif($dataku['nilai'] >= 60)
                                    <span class="px-3 py-1.5 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full inline-block">
                                        Cukup
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 text-xs font-semibold bg-rose-100 text-rose-700 rounded-full inline-block">
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
@endsection

</body>
</html>
