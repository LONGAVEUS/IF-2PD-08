@props(['selectedSemester' => ''])

<div class="flex flex-row items-center gap-3 w-full md:w-auto">
    <span class="text-sm font-semibold text-gray-500 hidden sm:block">Semester</span>
    <select name="semester" onchange="this.form.submit()"
        class="flex-1 md:flex-none bg-white border-2 border-indigo-50 text-gray-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2.5 outline-none font-bold cursor-pointer">
        <option value="">Semua Semester</option>
        {{-- Loop untuk semester 1 sampai 8 --}}
        @for ($i = 1; $i <= 8; $i++)
            <option value="{{ $i }}" {{ $selectedSemester == $i ? 'selected' : '' }}>
                Semester {{ $i }}
            </option>
        @endfor
    </select>
</div>
