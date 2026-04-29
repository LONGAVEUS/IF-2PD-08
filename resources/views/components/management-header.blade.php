@props(['title', 'buttonText', 'targetModal'])

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/40 shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-indigo-900 tracking-tight">{{ $title }}</h1>
            <p class="text-sm text-gray-500">Sistem Pengisian KRS dan Hasil Akhir (KHS)</p>
        </div>
    </div>
    {{-- Tombol menggunakan prop buttonText agar teksnya bisa berbeda dari judul --}}
    <button data-modal-target="{{ $targetModal }}" data-modal-toggle="{{ $targetModal }}"
        class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold px-6 py-3 rounded-xl shadow-lg shadow-indigo-500/30 transition-all flex items-center justify-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        {{ $buttonText }}
    </button>
</div>
