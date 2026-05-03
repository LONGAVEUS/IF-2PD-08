@extends('layouts.dosen_layout')

@section('content')
    <div class="space-y-6 pb-12">
        <div class="bg-white/80 backdrop-blur rounded-3xl shadow-xl border border-indigo-100 p-8">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-indigo-900 tracking-tight">
                        Dashboard Dosen
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Selamat datang, <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

                <div class="bg-white border border-indigo-100 rounded-2xl p-5 shadow-sm">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center mb-3">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M2 3h6a4 4 0 014 4v14a3 3 0 00-3-3H2z"/><path d="M22 3h-6a4 4 0 00-4 4v14a3 3 0 013-3h7z"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-semibold text-gray-900">{{ $jumlahMatkul }}</p>
                    <p class="text-xs text-gray-500 mt-1">Mata kuliah diampu</p>
                    <span class="mt-2 inline-block text-xs bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-full">semester ini</span>
                </div>

                <div class="bg-white border border-blue-100 rounded-2xl p-5 shadow-sm">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center mb-3">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-semibold text-gray-900">{{ $totalMahasiswa }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total mahasiswa</p>
                    <span class="mt-2 inline-block text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full">semua kelas</span>
                </div>

                <div class="bg-white border border-green-100 rounded-2xl p-5 shadow-sm">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center mb-3">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($rataRataSemua, 1) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Rata-rata nilai</p>
                    <span class="mt-2 inline-block text-xs bg-green-50 text-green-600 px-2 py-0.5 rounded-full">matkul selesai</span>
                </div>

                <div class="bg-white border border-red-100 rounded-2xl p-5 shadow-sm">
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center mb-3">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <p class="text-2xl font-semibold text-red-600">{{ $nilaiPending }}</p>
                    <p class="text-xs text-gray-500 mt-1">Nilai belum diinput</p>
                    <span class="mt-2 inline-block text-xs bg-red-50 text-red-500 px-2 py-0.5 rounded-full">segera selesaikan</span>
                </div>

            </div>

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Mata kuliah semester ini</p>
                        <p class="text-xs text-gray-400 mt-0.5">Semester 1 · {{ count($mataKuliah) }} mata kuliah</p>
                    </div>
                    <a href="{{ route('input_nilai') }}"
                        class="text-xs font-semibold bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            + Input nilai
                        </a>
                </div>

                <div class="divide-y divide-gray-50">
                    @foreach($mataKuliah as $index => $mk)
                        <div class="flex items-center gap-4 px-6 py-4">
                            <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-semibold">
                                {{ $index + 1 }}
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800">{{ $mk->nama_mk }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $mk->kode_mk }} · {{ $mk->sks }} SKS
                                </p>
                            </div>

                            <div class="flex flex-col items-end gap-1.5">
                                @if($mk->sudah_input)
                                    <span class="text-xs bg-green-50 text-green-700 px-2.5 py-0.5 rounded-full font-medium">
                                        Sudah input
                                    </span>
                                    <p class="text-xs font-semibold text-indigo-600">
                                        Rata-rata Bobot: {{ number_format($mk->rata_rata, 1) }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection
