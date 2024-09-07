@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center my-8">
        <div class="flex space-x-4">
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded cursor-default">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded hover:bg-gray-100">Previous</a>
            @endif
            <div class="hidden sm:gap-2 sm:flex-1 sm:flex sm:items-center sm:justify-between">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded cursor-default">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="px-4 py-2 bg-blue-500 text-white rounded">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded hover:bg-gray-100">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded hover:bg-gray-100">Next</a>
            @else
                <span class="px-4 py-2 bg-gray-300 text-gray-500 rounded cursor-default">Next</span>
            @endif
        </div>
    </nav>
@endif