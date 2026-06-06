@if ($paginator->hasPages())
<nav aria-label="Page navigation example" class="flex justify-between items-center px-4 py-3">
    <span class="text-sm text-gray-500">
        Menampilkan {{ $paginator->firstItem() }} sampai {{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
    </span>

    <ul class="flex -space-x-px text-sm">
        @if ($paginator->onFirstPage())
            <li>
                <span class="flex items-center justify-center text-gray-300 bg-gray-100 border border-indigo-50 font-medium rounded-s-xl text-sm px-3 h-10 cursor-not-allowed">Previous</span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center justify-center text-indigo-600 bg-white border border-indigo-50 hover:bg-indigo-50 font-medium rounded-s-xl text-sm px-3 h-10 transition">Previous</a>
            </li>
        @endif

   
        @foreach ($elements as $element)

            @if (is_string($element))
                <li>
                    <span class="flex items-center justify-center text-gray-400 bg-white border border-indigo-50 font-medium text-sm w-10 h-10">{{ $element }}</span>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())

                        <li>
                            <a href="#" aria-current="page" class="flex items-center justify-center text-white bg-indigo-600 border border-indigo-600 font-bold text-sm w-10 h-10 shadow-sm shadow-indigo-500/20">{{ $page }}</a>
                        </li>
                    @else

                        <li>
                            <a href="{{ $url }}" class="flex items-center justify-center text-gray-600 bg-white border border-indigo-50 hover:bg-indigo-50 font-medium text-sm w-10 h-10 transition">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center justify-center text-indigo-600 bg-white border border-indigo-50 hover:bg-indigo-50 font-medium rounded-e-xl text-sm px-3 h-10 transition">Next</a>
            </li>
        @else
            <li>
                <span class="flex items-center justify-center text-gray-300 bg-gray-100 border border-indigo-50 font-medium rounded-e-xl text-sm px-3 h-10 cursor-not-allowed">Next</span>
            </li>
        @endif
    </ul>
</nav>
@endif
