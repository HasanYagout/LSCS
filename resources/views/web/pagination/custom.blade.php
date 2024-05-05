@if ($paginator->hasPages())
    <ul class="zPagination-one pt-77">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li>
                <button class="z-link disabled"><i class="fa-solid fa-angles-left"></i></button>
            </li>
        @else
            <li>
                <a class="z-link" href="{{ $paginator->previousPageUrl() }}"><i class="fa-solid fa-angles-left"></i></a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li>
                    <button class="z-link border-0 disabled">{{ $element }}</button>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <button class="z-link active">{{ $page }}</button>
                        </li>
                    @else
                        <li><a class="z-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a class="z-link" href="{{ $paginator->nextPageUrl() }}"><i class="fa-solid fa-angles-right"></i></a>
            </li>
        @else
            <li>
                <button class="z-link disabled"><i class="fa-solid fa-angles-right"></i></button>
            </li>
        @endif
    </ul>
@endif

