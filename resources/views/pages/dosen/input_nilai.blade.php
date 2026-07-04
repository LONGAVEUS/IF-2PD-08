@extends('layouts.dosen_layout')

@section('content')

@if(session('success'))
<div id="notifSukses" class="fixed top-5 right-5 z-50 bg-green-50 border-2 border-green-400 text-green-700 px-5 py-4 rounded-xl shadow-lg flex items-center gap-3">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/>
        <path d="M9 12l2 2 4-4"/>
    </svg>
    <span class="text-sm font-medium">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div id="notifError" class="fixed top-5 right-5 z-50 bg-red-50 border-2 border-red-400 text-red-700 px-5 py-4 rounded-xl shadow-lg flex items-center gap-3">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="10"/>
        <path d="M12 8v4M12 16h.01"/>
    </svg>
    <span class="text-sm font-medium">{{ session('error') }}</span>
</div>
@endif

<div class="space-y-6">

    <div class="flex items-center gap-4 mb-7">
        <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/40 shrink-0">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 2L2 7l10 5 10-5-10-5z"/>
                <path d="M2 17l10 5 10-5"/>
                <path d="M2 12l10 5 10-5"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-indigo-900 tracking-tight">Form Input Nilai Mahasiswa</h1>
            <p class="text-sm text-gray-500 mt-1">Sistem Pengisian KRS dan Hasil Akhir (KHS)</p>
        </div>
    </div>
    <form action="{{ route('input_nilai') }}" method="GET" id="filterForm" class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-start gap-4 w-full">
            <div class="w-full md:max-w-xs bg-white border-2 border-indigo-50 rounded-xl p-4 flex flex-col justify-center focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-500/20 transition shadow-sm">
                <p class="text-xs font-bold tracking-wider uppercase text-indigo-600 mb-2">Mata Kuliah</p>
                <select id="matkul" name="kode_mk" onchange="document.getElementById('filterForm').submit()"
                        class="w-full bg-transparent border-none text-gray-900 font-medium text-sm p-0 cursor-pointer focus:ring-0 outline-none">
                    <option value="">-- Pilih Mata Kuliah --</option>
                    @foreach($daftarMatkul as $mk)
                        <option value="{{ $mk->kode_mk }}"
                                {{ (request('kode_mk') == $mk->kode_mk || (isset($matkulTerpilih) && $matkulTerpilih->kode_mk == $mk->kode_mk)) ? 'selected' : '' }}>
                            {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="bg-white border-2 border-indigo-50 rounded-xl p-4 shadow-sm min-w-[200px] flex items-center justify-center md:justify-end">
                <x-semester-filter :selectedSemester="$selectedSemester" />
            </div>
        </div>
    </form>

    @if($matkulTerpilih && $mahasiswaTerdaftar)
    <form action="{{ route('simpan_nilai') }}" method="POST" onsubmit="return validasiSebelumSubmit()">
        @csrf
        <input type="hidden" name="kode_mk" value="{{ $matkulTerpilih->kode_mk }}">

        <div class="bg-white border-2 border-indigo-50 rounded-2xl overflow-hidden shadow-lg shadow-indigo-500/5 overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead class="bg-indigo-50/50">
                    <tr>
                        <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100 w-16">No</th>
                        <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">NIM</th>
                        <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">Nama Mahasiswa</th>
                        <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">Nilai Angka</th>
                        <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">Nilai Huruf</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50">
    @foreach($mahasiswaTerdaftar as $index => $krs)
    <tr class="hover:bg-indigo-50/30 transition">
        <td class="px-5 py-4 text-sm text-gray-400 font-medium">{{ $index + 1 }}</td>
        <td class="px-5 py-4 text-sm font-medium text-gray-500">{{ $krs->mahasiswa_nim }}</td>
        <td class="px-5 py-4 font-semibold text-gray-800">{{ $krs->mahasiswa->user->name }}</td>
        <td class="px-5 py-4">
            <input type="hidden" name="krs_id[{{ $index }}]" value="{{ $krs->id_krs }}">
            <input type="number" name="nilai_angka[{{ $index }}]"
                value="{{ $krs->nilai->nilai_angka ?? '' }}"
                placeholder="0-100"
                oninput="recalc(this, {{ $index }})"
                class="w-24 bg-indigo-50 text-gray-900 border-2 border-indigo-100 rounded-lg px-2 py-1.5 text-center text-sm font-medium focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition" />
            <p class="text-xs text-red-500 mt-1 hidden" id="warning-{{ $index }}">Nilai harus 0-100!</p>
        </td>
        <td class="px-5 py-4">
            <span class="text-sm font-bold text-indigo-700" id="huruf-{{ $index }}">
                {{ $krs->nilai ? $krs->nilai->nilai_huruf : '-' }}
            </span>
        </td>
    </tr>
    @endforeach
</tbody>
            </table>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-indigo-600 text-white rounded-xl px-8 py-3 text-sm font-semibold shadow-lg
             shadow-indigo-500/30 hover:bg-indigo-700 active:scale-95 transition">
                Simpan Nilai
            </button>
        </div>
    </form>
    @else
    <div class="bg-white border-2 border-indigo-50 rounded-2xl p-10 text-center text-gray-400">
        Pilih mata kuliah terlebih dahulu
    </div>
    @endif

</div>

<script>
    function toHuruf(n) {
        if (n === "" || n === null) return "-";
        n = parseInt(n);

        if (n >= 85) return "A";
        if (n >= 80) return "A-";
        if (n >= 75) return "B+";
        if (n >= 70) return "B";
        if (n >= 65) return "B-";
        if (n >= 60) return "C+";
        if (n >= 55) return "C";
        if (n >= 50) return "C-";
        if (n >= 45) return "D+";
        if (n >= 40) return "D";
        return "E";
    }

    function recalc(input, index) {
        const warning = document.getElementById("warning-" + index);
        const huruf = document.getElementById("huruf-" + index);
        const nilai = parseFloat(input.value);

        if (input.value !== "" && (nilai > 100 || nilai < 0)) {
            warning.classList.remove("hidden");
            input.classList.add("border-red-500");
            huruf.textContent = "-";
        } else {
            warning.classList.add("hidden");
            input.classList.remove("border-red-500");
            huruf.textContent = toHuruf(input.value);
        }
    }

    function validasiSebelumSubmit() {
        const inputs = document.querySelectorAll('input[name^="nilai_angka"]');
        for (let input of inputs) {
            const nilai = parseFloat(input.value);
            if (input.value !== "" && (nilai > 100 || nilai < 0)) {
                alert("Masih ada nilai yang salah (harus 0-100). Cek lagi ya!");
                return false;
            }
        }
        return confirm('Apakah Anda yakin semua nilai angka yang diinput sudah benar? Nilai yang disimpan akan langsung terbit di KHS mahasiswa.');
    }

    setTimeout(() => {
        const sukses = document.getElementById('notifSukses');
        const error = document.getElementById('notifError');
        if (sukses) sukses.style.display = 'none';
        if (error) error.style.display = 'none';
    }, 3000);
</script>
@endsection