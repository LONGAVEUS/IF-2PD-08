<!DOCTYPE html>
<html>
<head>
    <title>Pengaturan KRS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

<!-- Header -->
<div class="mb-6">
    <h1 class="text-3xl font-bold">Pengaturan KRS</h1>
    <p class="text-gray-500">Kelola aturan dan periode pengisian KRS mahasiswa</p>
</div>

<div class="grid grid-cols-3 gap-6">

    <!-- FORM -->
    <div class="col-span-2 bg-white p-6 rounded-xl shadow">

        <h2 class="text-lg font-semibold mb-4">Form Pengaturan</h2>

        <form class="space-y-4">

            <!-- Mulai Pengisian -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Mulai Pengisian
                </label>
                <input type="date"
                       class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Batas Pengisian -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Batas Pengisian
                </label>
                <input type="date"
                       class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Semester -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Semester
                </label>
                <input type="text" placeholder="Contoh: Semester Genap 2024/2025"
                       class="w-full border border-gray-300 rounded-lg p-2">
            </div>

            <!-- Maksimal SKS -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Maksimal SKS
                </label>
                <input type="number" placeholder="Contoh: 24"
                       class="w-full border border-gray-300 rounded-lg p-2">
            </div>

            <!-- IPK / IPS -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    IPK / IPS
                </label>
                <input type="number" step="0.01" placeholder="Contoh: 3.00"
                       class="w-full border border-gray-300 rounded-lg p-2">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Status KRS
                </label>
                <select class="w-full border border-gray-300 rounded-lg p-2">
                    <option>Aktif</option>
                    <option>Nonaktif</option>
                </select>
            </div>

            <!-- Button -->
            <div class="pt-3">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Simpan Pengaturan
                </button>
            </div>

        </form>

    </div>

    <!-- SIDEBAR -->
    <div class="space-y-4">

        <!-- Status -->
        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold mb-2">Status Saat Ini</h2>
            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                KRS Aktif
            </span>
        </div>

        <!-- Periode -->
        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold mb-2">Periode KRS</h2>
            <p class="text-gray-600 text-sm">
                1 September - 10 September
            </p>
        </div>

        <!-- Aturan -->
        <div class="bg-white p-5 rounded-xl shadow">
            <h2 class="font-semibold mb-2">Aturan Sistem</h2>
            <ul class="text-gray-600 text-sm space-y-1">
                <li>📌 Maks SKS: 24</li>
                <li>📌 IPK/IPS: 3.00</li>
                <li>📌 Semester: Genap 2024/2025</li>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-xl shadow col-span-2">

            <h2 class="font-semibold mb-3">Progress KRS</h2>

            <div class="flex justify-between text-sm mb-1">
                <span>Pengisian KRS</span>
                <span class="font-semibold text-blue-600">67%</span>
            </div>

            <!-- FULL WIDTH BAR -->
            <div class="w-full bg-gray-200 h-3 rounded-full">
                <div class="bg-blue-600 h-3 rounded-full" style="width: 67%"></div>
            </div>

            <p class="text-xs text-gray-500 mt-2">
                80 dari 120 mahasiswa sudah mengisi
            </p>

        </div>

    </div>

</div>

</body>
</html>