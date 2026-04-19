<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    @extends('layouts.mahasiswa_layout')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- ══ PAGE HEADER ══ --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm px-7 py-6
                flex flex-col md:flex-row md:items-center md:justify-between gap-3
                animate-[fadeUp_0.42s_ease_both]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1"/>
                    <line x1="9" y1="12" x2="15" y2="12"/>
                    <line x1="9" y1="16" x2="13" y2="16"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-indigo-900 tracking-tight">Kartu Rencana Studi (KRS)</h1>
                <p class="text-slate-400 text-sm mt-0.5">Sistem Pengisian KRS dan Hasil Akhir (KHS)</p>
            </div>
        </div>
    </div>

    {{-- ══ INFO CARDS: Tanggal & IPK ══ --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6
                animate-[fadeUp_0.42s_0.07s_ease_both]">
        <div class="bg-slate-50 rounded-xl border border-slate-100 grid grid-cols-2 md:grid-cols-4 divide-x divide-y md:divide-y-0 divide-slate-100">
            <div class="p-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Mulai Pengisian</p>
                <p class="text-base font-bold text-slate-700">
                    {{ isset($mulaiPengisian) ? \Carbon\Carbon::parse($mulaiPengisian)->format('d - m - Y') : '20 - 01 - 2025' }}
                </p>
            </div>
            <div class="p-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Batas Pengisian</p>
                <p class="text-base font-bold text-slate-700">
                    {{ isset($batasPengisian) ? \Carbon\Carbon::parse($batasPengisian)->format('d - m - Y') : '25 - 01 - 2025' }}
                </p>
            </div>
            <div class="p-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Semester</p>
                <p class="text-lg font-extrabold text-slate-700">
                    {{ $semesterAktif ?? 'Genap 2025/2026' }}
                </p>
            </div>
            <div class="p-4">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">IPK / IPS</p>
                <p class="text-lg font-extrabold text-slate-700">
                    {{ number_format(Auth::user()->ip_kumulatif, 2) }}
                    <span class="text-slate-400 font-semibold">/</span>
                    {{ number_format(Auth::user()->ip_semester, 2) }}
                </p>
            </div>
        </div>
    </div>

    {{-- ══ DAFTAR MATA KULIAH TERDAFTAR ══ --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden
                animate-[fadeUp_0.42s_0.14s_ease_both]">

        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-800">Daftar Mata Kuliah Terpilih</h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    Total:
                    <span class="font-semibold text-slate-600">{{ $mataKuliahTerdaftar->count() }} mata kuliah</span>
                    &nbsp;·&nbsp;
                    <span class="font-semibold text-slate-600">{{ $mataKuliahTerdaftar->sum('sks') }} SKS</span>
                </p>
            </div>
            <button data-modal-target="modalPilihMK" data-modal-toggle="modalPilihMK"
                class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700
                    transition-colors text-white text-sm font-semibold px-4 py-2 rounded-xl shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5"  y1="12" x2="19" y2="12"/>
            </svg>
            Pilih Mata Kuliah
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-800 text-white">
                        <th class="px-5 py-3.5 text-left font-semibold text-xs uppercase tracking-wider w-12">NO</th>
                        <th class="px-5 py-3.5 text-left font-semibold text-xs uppercase tracking-wider">Kode MK</th>
                        <th class="px-5 py-3.5 text-left font-semibold text-xs uppercase tracking-wider">Nama Mata Kuliah</th>
                        <th class="px-5 py-3.5 text-center font-semibold text-xs uppercase tracking-wider w-16">SKS</th>
                        <th class="px-5 py-3.5 text-left font-semibold text-xs uppercase tracking-wider">Dosen</th>
                        <th class="px-5 py-3.5 text-center font-semibold text-xs uppercase tracking-wider w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($mataKuliahTerdaftar as $index => $item)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-5 py-4 text-slate-500 font-medium">{{ $index + 1 }}</td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg
                                         text-xs font-bold bg-indigo-50 text-indigo-600">
                                {{ $item->mataKuliah->kode_mk }}
                            </span>
                        </td>
                        <td class="px-5 py-4 font-semibold text-slate-800">{{ $item->mataKuliah->nama_mk }}</td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg
                                         bg-slate-100 text-slate-700 font-bold text-xs">
                                {{ $item->mataKuliah->sks }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-slate-600">{{ $item->mataKuliah->dosen->name ?? '-' }}</td>
                        <td class="px-5 py-4 text-center">
                            <form action="{{ route('krs.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus mata kuliah ini dari KRS?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg
                                               text-xs font-semibold bg-red-50 text-red-500
                                               hover:bg-red-100 transition-colors border border-red-100">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                        <path d="M10 11v6M14 11v6"/>
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                                        <rect x="9" y="3" width="6" height="4" rx="1"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-slate-500">Belum ada mata kuliah terdaftar</p>
                                <p class="text-xs text-slate-400">Klik "+ Pilih Mata Kuliah" untuk mulai mengisi KRS</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tombol Simpan --}}
        @if($mataKuliahTerdaftar->count() > 0)
        <div class="px-6 py-4 border-t border-slate-100 flex justify-end">
            <form action="{{ route('krs.store') }}" method="POST">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700
                               transition-colors text-white text-sm font-semibold px-6 py-2.5 rounded-xl shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Simpan KRS
                </button>
            </form>
        </div>
        @endif

    </div>{{-- /table card --}}

</div>{{-- /max-w --}}

<!-- Modal Pilih Mata Kuliah-->
<div id="modalPilihMK" tabindex="-1" aria-hidden="true"
     class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative p-4 w-full max-w-2xl max-h-full">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
      <!-- Header -->
      <div class="flex items-center justify-between p-4 border-b rounded-t">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
          Pilih Mata Kuliah
        </h3>
        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200
               hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                data-modal-hide="modalPilihMK">
          ✕
        </button>
      </div>
      <!-- Body -->
      <div class="p-6 space-y-6">
        @forelse($mataKuliahTersedia as $mk)
          <div class="flex justify-between items-center border-b py-2">
            <div>
              <p class="font-semibold">{{ $mk->nama_mk }}</p>
              <p class="text-sm text-gray-500">{{ $mk->kode_mk }} • {{ $mk->sks }} SKS</p>
            </div>
            <form action="{{ route('mahasiswa.krs.tambah') }}" method="POST">
              @csrf
              <input type="hidden" name="mata_kuliah_id" value="{{ $mk->id }}">
              <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded">Tambah</button>
            </form>
          </div>
        @empty
          <p class="text-gray-400 text-center">Tidak ada mata kuliah tersedia</p>
        @endforelse
      </div>
    </div>
  </div>
</div>

@endsection

</body>
</html>
