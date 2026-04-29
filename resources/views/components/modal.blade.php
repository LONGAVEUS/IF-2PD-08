@props(['id', 'title'])

<div id="{{ $id }}" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full overflow-y-auto overflow-x-hidden p-4">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-[#F3F4F6] rounded-3xl shadow-2xl overflow-hidden border border-white">
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200 bg-white/50 backdrop-blur-sm">
                <h3 class="text-lg md:text-xl font-extrabold text-indigo-900 tracking-tight">
                    {{ $title }}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-red-50 hover:text-red-500 rounded-xl text-sm w-9 h-9 ms-auto inline-flex justify-center items-center transition-colors" data-modal-hide="{{ $id }}">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>

            <div class="p-4 md:p-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
