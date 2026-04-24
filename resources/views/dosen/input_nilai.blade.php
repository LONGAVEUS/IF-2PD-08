<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Form Input Nilai Mahasiswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
@extends('layouts.dosen_layout')

@section('content')
<div class="max-w-6xl mx-auto">

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

    <div class="flex flex-wrap gap-3 mb-6">
        <div class="bg-white border-2 border-indigo-50 rounded-xl p-4 flex-1 min-w-[200px] focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-500/20 transition shadow-sm">
            <p class="text-xs font-bold tracking-wider uppercase text-indigo-600 mb-2">Mata Kuliah</p>
            <select id="matkul"
                    class="w-full bg-transparent border-none text-gray-900 font-medium text-sm p-0 cursor-pointer focus:ring-0 outline-none"
                    onchange="location = this.value;">

                <option value="">-- Pilih Mata Kuliah --</option>

                @foreach($daftarMatkul as $mk)
                    <option value="{{ route('input_nilai', $mk->kode_mk) }}"
                            {{ (isset($matkulTerpilih) && $matkulTerpilih->kode_mk == $mk->kode_mk) ? 'selected' : '' }}>
                        {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                    </option>
                @endforeach

            </select>
        </div>
        <div class="bg-white border-2 border-indigo-50 rounded-xl p-4 flex-1 min-w-[130px] focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-500/20 transition shadow-sm">
            <p class="text-xs font-bold tracking-wider uppercase text-indigo-600 mb-2">Kelas</p>
            <select id="kelas" class="w-full bg-transparent border-none text-gray-900 font-medium text-sm p-0 cursor-pointer focus:ring-0 outline-none">
                <option value="IF2D Pagi" selected>IF2D Pagi</option>
                <option value="IF-3A">IF-3A</option>
                <option value="IF-3B">IF-3B</option>
                <option value="IF-3C">IF-3C</option>
                <option value="IF-4A">IF-4A</option>
            </select>
        </div>
        <div class="bg-white border-2 border-indigo-50 rounded-xl p-4 flex-1 min-w-[150px] focus-within:border-indigo-500 focus-within:ring-4 focus-within:ring-indigo-500/20 transition shadow-sm">
            <p class="text-xs font-bold tracking-wider uppercase text-indigo-600 mb-2">Semester</p>
            <select id="semester" class="w-full bg-transparent border-none text-gray-900 font-medium text-sm p-0 cursor-pointer focus:ring-0 outline-none">
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                <option value="3">Semester 3</option>
                <option value="4">Semester 4</option>
                <option value="5">Semester 5</option>
                <option value="6">Semester 6</option>
                <option value="7">Semester 7</option>
                <option value="8">Semester 8</option>
            </select>
        </div>
    </div>

    <div class="bg-white border-2 border-indigo-50 rounded-2xl overflow-hidden shadow-lg shadow-indigo-500/5 overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead class="bg-indigo-50/50">
                <tr>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100 w-16">No</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">NIM</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">Nama Mahasiswa</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">Nilai Angka</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">Nilai Huruf</th>
                    <th class="text-xs font-semibold uppercase tracking-wider text-indigo-800 px-5 py-4 border-b-2 border-indigo-100">Keterangan</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="divide-y divide-indigo-50">
            </tbody>
        </table>
    </div>

    <div class="flex justify-end mt-6">
        <button class="bg-indigo-600 text-white rounded-xl px-8 py-3 text-sm font-semibold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 active:scale-95 transition" onclick="simpan()">
            Simpan Nilai
        </button>
    </div>

</div>

<script>
    const mahasiswa = [
        { nim: "2021001", nama: "Peter Parker" },
        { nim: "2021002", nama: "Tony Stark" },
        { nim: "2021003", nama: "Natalia Romanoff" },
    ];

    function toHuruf(n) {
        if (n === "" || n === null) return "E";
        n = parseInt(n);
        if (n >= 85) return "A";
        if (n >= 75) return "B";
        if (n >= 65) return "C";
        if (n >= 55) return "D";
        return "E";
    }

    function updateTable() {
        const tbody = document.getElementById("tableBody");
        const saved = {};

        tbody.querySelectorAll("tr").forEach(tr => {
            const inp = tr.querySelector("input[type='number']");
            if (inp) saved[tr.dataset.nim] = inp.value;
        });

        tbody.innerHTML = "";

        mahasiswa.forEach((m, index) => {
            const val = saved[m.nim] || "";
            const huruf = toHuruf(val);
            const tr = document.createElement("tr");

            tr.dataset.nim = m.nim;
            tr.className = "hover:bg-indigo-50/30 transition";

            tr.innerHTML = `
                <td class="px-5 py-4 align-middle text-sm text-gray-400 font-medium">${index + 1}</td>
                <td class="px-5 py-4 align-middle">
                    <span class="text-sm font-medium text-gray-500">${m.nim}</span>
                </td>
                <td class="px-5 py-4 align-middle font-semibold text-gray-800">${m.nama}</td>
                <td class="px-5 py-4 align-middle">
                    <input type="number" min="0" max="100" value="${val}" placeholder="0-100" oninput="recalc(this, '${m.nim}')" class="w-24 bg-indigo-50 text-gray-900 border-2 border-indigo-100 rounded-lg px-2 py-1.5 text-center text-sm font-medium focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition" />
                </td>
                <td class="px-5 py-4 align-middle">
                    <span class="text-sm font-bold text-indigo-700" id="huruf-${m.nim}">${huruf}</span>
                </td>
                <td class="px-5 py-4 align-middle">
                    <input type="text" placeholder="Isi keterangan disini" class="w-full bg-indigo-50 text-gray-700 border-2 border-indigo-100 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition" />
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    function recalc(input, nim) {
        const huruf = toHuruf(input.value);
        document.getElementById("huruf-" + nim).textContent = huruf;
    }

    function simpan() {
        const matkul = document.getElementById("matkul");
        const matkulText = matkul.options[matkul.selectedIndex].text;
        const kelas = document.getElementById("kelas").value;
        const semester = document.getElementById("semester").value;
        alert("Nilai berhasil disimpan!\n" + matkulText + " | " + kelas + " | Semester " + semester);
    }

    updateTable();
</script>
@endsection

</body>
</html>