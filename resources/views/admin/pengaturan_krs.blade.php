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
    
@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-7">
        <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/40 shrink-0">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 11l3 3L22 4"/>
                <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-indigo-900 tracking-tight">Pengaturan KRS</h1>
            <p class="text-sm text-gray-500 mt-1">Sistem Pengisian KRS dan Hasil Akhir (KHS)</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white border-2 border-indigo-50 rounded-2xl shadow-lg shadow-indigo-500/5 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-5 border-b-2 border-indigo-50">
            <p class="text-base font-semibold text-indigo-900">Konfigurasi Pengisian KRS</p>
            <p class="text-sm text-gray-400 mt-0.5">Atur semester dan batasan SKS.</p>
        </div>

        {{-- Card Body --}}
        <div class="p-6">

            @if(session('success'))
                <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-4 py-3 rounded-xl">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('pengaturan_krs.simpan') }}">
            @csrf

            <div class="flex gap-6">
                {{-- Dropdown Semester --}}
                <div class="flex-1">
                    <p class="text-xs font-bold tracking-wider uppercase text-indigo-600 mb-2">Pilih Semester:</p>
                    <div class="bg-white border-2 border-indigo-50 rounded-xl p-4 focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-500/20 transition shadow-sm max-w-sm">
                        <select id="semester" name="semester" class="w-full bg-transparent border-none text-gray-900 font-medium text-sm p-0 cursor-pointer focus:ring-0 outline-none">
                            @for($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}" {{ (isset($pengaturan) && $pengaturan->semester == $i) ? 'selected' : ($i == 1 ? 'selected' : '') }}>
                                    Semester {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                {{-- Input Maksimal SKS --}}
                <div class="flex-1">
                <p class="text-xs font-bold tracking-wider uppercase text-indigo-600 mb-2">Maksimal SKS:</p>
                <div class="bg-white border-2 border-indigo-50 rounded-xl p-4 focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-500/20 transition shadow-sm max-w-sm">
                    <input type="number"
                        name="max_sks"
                        min="1"
                        max="100"
                        placeholder="Ketik batas SKS disini..."
                        value="{{ old('max_sks', $config->max_sks ?? '') }}"
                        class="w-full bg-transparent border-none text-gray-900 font-medium text-sm p-0 cursor-pointer focus:ring-0 outline-none">
                </div>
                </div>
            </div>
            {{-- Tombol Simpan --}}
                <div class="flex justify-end mt-6">
                    <button onclick="simpan()"
                        class="bg-indigo-600 text-white rounded-xl px-8 py-3 text-sm font-semibold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 active:scale-95 transition">
                        Simpan
                    </button>
                </div>
        </div>
    </div>

</div>

<script>
    function simpan() {
        const semester = document.getElementById('semester').value;
        const maxSks = document.querySelector('input[name="max_sks"]').value;

        alert(
            'Pengaturan berhasil disimpan!\n' +
            'Semester aktif: Semester ' + semester + '\n' +
            'Maksimal SKS: ' + maxSks
        );
    }
</script>

@endsection
</body>
</html>
