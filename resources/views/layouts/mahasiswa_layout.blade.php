<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akademik - Mahasiswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <x-navbar title="Portal Mahasiswa" />
    <x-sidebar-mahasiswa />

    <div class="p-4 sm:ml-64 mt-14 min-h-screen flex flex-col">

        <div class="flex-grow pb-10">
            @yield('content')
        </div>

        <x-footer />
    </div>
</body>
</html>
