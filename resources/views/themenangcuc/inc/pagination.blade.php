@if ($paginator->hasPages())
    <style>
        #pagination {
            display: block !important;
        }
        #pagination > li {
            margin: 3px;
            display: inline-block;
        }
        #pagination > li > .page-link,
        #pagination > .page-item > span {
            /*border-radius: 4px;*/
            background: #444;
            color: #fff;
            border: 0;
        }
        #pagination > li.active > .page-link {
            background: #222222 ;
            border: 1px solid #444444;
        }
    </style>

    <ul id="pagination" class="pagination-list pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        @else
            <li class="page-item prev">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    &laquo;
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true">
                    <span class="">{{ $element }}</span>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link" href="javascript:void(0)">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item next">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                    &raquo;
                </a>
            </li>
        @else
        @endif
    </ul>
@endif
