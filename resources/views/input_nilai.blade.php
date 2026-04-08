<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Form Input Nilai Mahasiswa</title>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --indigo: #4F46E5;
      --indigo-dark: #3730A3;
      --indigo-light: #EEF2FF;
      --teal: #0D9488;
      --teal-light: #CCFBF1;
      --rose: #E11D48;
      --rose-light: #FFE4E6;
      --surface: #FFFFFF;
      --bg: #F0F0FF;
      --text: #1E1B4B;
      --muted: #6B7280;
      --border: #C7D2FE;
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Sora', sans-serif;
      background: var(--bg);
      background-image:
        radial-gradient(circle at 15% 15%, #ddd6fe55 0%, transparent 45%),
        radial-gradient(circle at 85% 85%, #a5f3fc33 0%, transparent 45%);
      color: var(--text);
      padding: 2rem;
      min-height: 100vh;
    }

    .header { display: flex; align-items: center; gap: 14px; margin-bottom: 1.75rem; }
    .header-icon {
      width: 44px; height: 44px; border-radius: 12px;
      background: var(--indigo);
      display: flex; align-items: center; justify-content: center;
      box-shadow: 0 4px 12px #4F46E540;
      flex-shrink: 0;
    }
    h1 { font-size: 20px; font-weight: 700; color: var(--indigo-dark); letter-spacing: -0.3px; }
    .subtitle { font-size: 12px; color: var(--muted); margin-top: 2px; }

    .info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 1.5rem; }
    .info-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: 12px; padding: 12px 16px;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .info-card:focus-within {
      border-color: var(--indigo);
      box-shadow: 0 0 0 3px #4F46E520;
    }
    .info-label {
      font-size: 10px; font-weight: 600; letter-spacing: 0.7px;
      text-transform: uppercase; color: var(--indigo); margin-bottom: 6px;
    }
    select {
      width: 100%; background: transparent; color: var(--text);
      border: none; padding: 0; font-size: 14px; font-weight: 500;
      font-family: 'Sora', sans-serif; cursor: pointer; appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%234F46E5' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
      background-repeat: no-repeat; background-position: right 2px center;
      padding-right: 20px;
    }
    select:focus { outline: none; }

    .table-wrap {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: 16px; overflow: hidden;
      box-shadow: 0 4px 24px #4F46E510;
    }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: var(--indigo-light); }
    th {
      font-size: 11px; font-weight: 600; letter-spacing: 0.5px;
      text-transform: uppercase; color: var(--indigo);
      padding: 13px 16px; text-align: left;
      border-bottom: 1.5px solid var(--border);
    }
    td {
      font-size: 14px; color: var(--text);
      padding: 14px 16px; border-bottom: 1px solid #E0E7FF;
      vertical-align: middle;
    }
    tr:last-child td { border-bottom: none; }
    tbody tr:hover td { background: #F5F3FF; }

    .nim-badge {
      font-size: 11px; font-weight: 600; color: #fff;
      background: var(--indigo); border-radius: 6px;
      padding: 3px 8px; display: inline-block; letter-spacing: 0.3px;
    }
    .nama { font-weight: 600; }

    .badge-lulus {
      background: var(--teal-light); color: var(--teal);
      font-size: 11px; font-weight: 600; padding: 4px 12px;
      border-radius: 20px; display: inline-block; letter-spacing: 0.3px;
    }
    .badge-tidak {
      background: var(--rose-light); color: var(--rose);
      font-size: 11px; font-weight: 600; padding: 4px 12px;
      border-radius: 20px; display: inline-block; letter-spacing: 0.3px;
    }
    .huruf-box {
      background: var(--indigo-light); border: 1.5px solid var(--border);
      border-radius: 8px; padding: 5px 12px; font-size: 14px;
      font-weight: 700; color: var(--indigo); min-width: 42px;
      text-align: center; display: inline-block;
    }
    input[type=number] {
      width: 80px; background: var(--indigo-light);
      color: var(--text); border: 1.5px solid var(--border);
      border-radius: 8px; padding: 6px 8px; text-align: center;
      font-size: 14px; font-weight: 500; font-family: 'Sora', sans-serif;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    input[type=number]:focus {
      outline: none; border-color: var(--indigo);
      box-shadow: 0 0 0 3px #4F46E520;
    }
    input[type=number]::-webkit-inner-spin-button { opacity: 0.4; }

    .footer { display: flex; justify-content: flex-end; margin-top: 1.25rem; }
    .btn-save {
      background: var(--indigo); color: #fff; border: none;
      border-radius: 10px; padding: 11px 28px;
      font-size: 14px; font-weight: 600; font-family: 'Sora', sans-serif;
      cursor: pointer; letter-spacing: 0.2px;
      box-shadow: 0 4px 12px #4F46E540;
      transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
    }
    .btn-save:hover { background: var(--indigo-dark); box-shadow: 0 6px 16px #4F46E550; }
    .btn-save:active { transform: scale(0.98); }
  </style>
</head>
<body>

<div class="header">
  <div class="header-icon">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 2L2 7l10 5 10-5-10-5z"/>
      <path d="M2 17l10 5 10-5"/>
      <path d="M2 12l10 5 10-5"/>
    </svg>
  </div>
  <div>
    <h1>Form Input Nilai Mahasiswa</h1>
    <p class="subtitle">Sistem Informasi Akademik</p>
  </div>
</div>

<div class="info-grid">
  <div class="info-card">
    <p class="info-label">Mata Kuliah</p>
    <select id="matkul" onchange="updateTable()">
      <option value="IF301">IF301 - Pemrograman Web</option>
      <option value="IF302">IF302 - Basis Data</option>
      <option value="IF303">IF303 - Jaringan Komputer</option>
      <option value="IF304">IF304 - Algoritma &amp; Pemrograman</option>
    </select>
  </div>
  <div class="info-card">
    <p class="info-label">Kelas</p>
    <select id="kelas">
      <option value="IF-3A">IF-3A</option>
      <option value="IF-3B" selected>IF-3B</option>
      <option value="IF-3C">IF-3C</option>
      <option value="IF-4A">IF-4A</option>
      <option value="IF-4B">IF-4B</option>
    </select>
  </div>
  <div class="info-card">
    <p class="info-label">Semester</p>
    <select id="semester">
      <option value="Ganjil 2023">Ganjil 2023</option>
      <option value="Genap 2024" selected>Genap 2024</option>
      <option value="Ganjil 2024">Ganjil 2024</option>
      <option value="Genap 2025">Genap 2025</option>
    </select>
  </div>
</div>

<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>NIM</th>
        <th>Nama Mahasiswa</th>
        <th>Nilai Angka</th>
        <th>Nilai Huruf</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody id="tableBody"></tbody>
  </table>
</div>

<div class="footer">
  <button class="btn-save" onclick="simpan()">Simpan Nilai</button>
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

  function isLulus(h) { return ["A", "B", "C", "D"].includes(h); }

  function updateTable() {
    const tbody = document.getElementById("tableBody");
    const saved = {};
    tbody.querySelectorAll("tr").forEach(tr => {
      const inp = tr.querySelector("input");
      if (inp) saved[tr.dataset.nim] = inp.value;
    });
    tbody.innerHTML = "";
    mahasiswa.forEach(m => {
      const val = saved[m.nim] || "";
      const huruf = toHuruf(val);
      const lulus = isLulus(huruf);
      const tr = document.createElement("tr");
      tr.dataset.nim = m.nim;
      tr.innerHTML = `
        <td><span class="nim-badge">${m.nim}</span></td>
        <td class="nama">${m.nama}</td>
        <td><input type="number" min="0" max="100" value="${val}" placeholder="0-100" oninput="recalc(this, '${m.nim}')" /></td>
        <td><span class="huruf-box" id="huruf-${m.nim}">${huruf}</span></td>
        <td><span class="${lulus ? 'badge-lulus' : 'badge-tidak'}" id="status-${m.nim}">${lulus ? 'Lulus' : 'Tidak Lulus'}</span></td>
      `;
      tbody.appendChild(tr);
    });
  }

  function recalc(input, nim) {
    const huruf = toHuruf(input.value);
    const lulus = isLulus(huruf);
    document.getElementById("huruf-" + nim).textContent = huruf;
    const s = document.getElementById("status-" + nim);
    s.textContent = lulus ? "Lulus" : "Tidak Lulus";
    s.className = lulus ? "badge-lulus" : "badge-tidak";
  }

  function simpan() {
    const matkul = document.getElementById("matkul");
    const matkulText = matkul.options[matkul.selectedIndex].text;
    const kelas = document.getElementById("kelas").value;
    const semester = document.getElementById("semester").value;
    alert("Nilai berhasil disimpan!\n" + matkulText + " | " + kelas + " | " + semester);
  }

  updateTable();
</script>

</body>
</html>