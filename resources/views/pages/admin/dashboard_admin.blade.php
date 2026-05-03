@extends('layouts.admin_layout')

@section('content')
<div class="space-y-6 pb-12">

    {{-- HEADER --}}
    <div class="flex justify-between items-start gap-2">
        <div class="max-w-[60%]">
            <h1 class="text-xl md:text-3xl font-extrabold text-indigo-900 tracking-tight leading-tight">Dashboard Admin</h1>
            <p class="text-[10px] md:text-sm font-semibold text-indigo-600 mt-1 bg-indigo-50 inline-block px-2 py-0.5 rounded-full">
                Admin 👋
            </p>
        </div>

        {{-- DROPDOWN SEMESTER --}}
        <form action="{{ route('dashboard_admin') }}" method="GET"
            class="flex items-center gap-3 bg-white border-2 border-indigo-50 rounded-xl px-4 py-2 shadow-sm">
            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <select name="semester" onchange="this.form.submit()"
                class="border-none bg-transparent focus:ring-0 text-sm font-bold text-slate-700 py-1 pl-1 pr-8 cursor-pointer outline-none">
                <option value="1" {{ $selectedSemester == 1 ? 'selected' : '' }}>Semester 1</option>
                <option value="2" {{ $selectedSemester == 2 ? 'selected' : '' }}>Semester 2</option>
            </select>
        </form>
    </div>

    {{-- STAT CARDS  --}}
    <div class="grid grid-cols-3 gap-2 md:gap-6">
        {{-- Total Mahasiswa --}}
        <div class="bg-white border-2 border-indigo-50 rounded-xl p-3 md:p-6 shadow-sm">
            <p class="text-xl md:text-4xl font-extrabold text-slate-800">{{ $totalMahasiswa }}</p>
            <p class="text-[9px] md:text-sm font-medium text-slate-500 leading-tight">Mahasiswa</p>
            <span class="hidden md:inline-block mt-3 text-xs font-bold bg-indigo-50 text-indigo-600 px-2.5 py-1 rounded-full">Semester {{ $selectedSemester }}</span>
        </div>

        {{-- Total Dosen --}}
        <div class="bg-white border-2 border-indigo-50 rounded-xl p-3 md:p-6 shadow-sm">
            <p class="text-xl md:text-4xl font-extrabold text-slate-800">{{ $totalDosen }}</p>
            <p class="text-[9px] md:text-sm font-medium text-slate-500 leading-tight">Dosen</p>
            <span class="hidden md:inline-block mt-3 text-xs font-bold bg-purple-50 text-purple-600 px-2.5 py-1 rounded-full">Aktif</span>
        </div>

        {{-- Mata Kuliah --}}
        <div class="bg-white border-2 border-indigo-50 rounded-xl p-3 md:p-6 shadow-sm">
            <p class="text-xl md:text-4xl font-extrabold text-slate-800">{{ $totalMatkulCount }}</p>
            <p class="text-[9px] md:text-sm font-medium text-slate-500 leading-tight">Mata Kuliah</p>
            <span class="hidden md:inline-block mt-3 text-xs font-bold bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full">Total</span>
        </div>
    </div>

    {{-- ══ BOTTOM SECTION  ══ --}}
    <div class="grid grid-cols-2 lg:grid-cols-12 gap-3 md:gap-6">
        <div class="lg:col-span-7 bg-white border-2 border-indigo-50 rounded-2xl shadow-sm overflow-hidden h-fit">
            <div class="p-6 border-b border-indigo-50 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Mata kuliah aktif</h2>
                    <p class="text-xs text-slate-500 mt-1">Semester {{ $selectedSemester }} - {{ $totalMatkulCount }}
                        mata kuliah</p>
                </div>
            </div>

            <div class="divide-y divide-indigo-50">
                @forelse($mataKuliahAktif as $index => $mk)
                <div class="flex items-center justify-between p-5 hover:bg-indigo-50/30 transition">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-700 font-bold flex items-center justify-center">
                            {{ $index + 1 }}</div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $mk->nama_mk }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">
                                {{ $mk->kode_mk }} · Sem {{ $mk->semester }} ·
                                {{ $mk->dosen->user->name ?? 'Belum Ada Dosen' }}
                            </p>
                        </div>
                    </div>
                    <span class="text-xs font-bold bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-lg">{{ $mk->sks }}
                        SKS</span>
                </div>
                @empty
                <div class="p-10 text-center text-slate-400">Tidak ada mata kuliah aktif di semester ini.</div>
                @endforelse
            </div>
        </div>

        {{-- Menu Pengelolaan --}}
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white border-2 border-indigo-50 rounded-2xl shadow-sm overflow-hidden h-fit">
                <div class="p-6 border-b border-indigo-50">
                    <h2 class="text-lg font-bold text-slate-800">Menu Pengelolaan</h2>
                    <p class="text-xs text-slate-500 mt-1">Akses cepat ke semua fitur</p>
                </div>

                <div class="p-3 space-y-2">
                    {{-- Shortcut: Data Mata Kuliah  --}}
                    <a href="#"
                        class="flex items-center justify-between p-4 hover:bg-indigo-50 rounded-xl transition group">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Data Mata Kuliah</p>
                                <p class="text-[10px] font-medium text-slate-400">Kelola daftar & kurikulum mata kuliah
                                </p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-blue-600 transition" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6"></path>
                        </svg>
                    </a>

                    {{-- Shortcut: Data KRS --}}
                    <a href="{{ route('admin_krs') }}"
                        class="flex items-center justify-between p-4 hover:bg-indigo-50 rounded-xl transition group">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10 9 9 9 8 9"></polyline>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Data KRS</p>
                                <p class="text-[10px] font-medium text-slate-400">Monitor pengisian KRS mahasiswa</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-indigo-600 transition" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6"></path>
                        </svg>
                    </a>

                    {{-- Shortcut: Data KHS --}}
                    <a href="{{ route('admin_khs') }}"
                        class="flex items-center justify-between p-4 hover:bg-indigo-50 rounded-xl transition group">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-full bg-violet-50 text-violet-600 flex items-center justify-center group-hover:scale-110 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-slate-800">Data KHS</p>
                                <p class="text-[10px] font-medium text-slate-400">Lihat nilai akhir per mahasiswa</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-violet-600 transition" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
