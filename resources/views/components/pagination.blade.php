@props(['paginator'])

@if ($paginator->hasPages())
<nav class="pagination-wrapper">
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="pagination-item pagination-item-disabled">
                <span class="pagination-link">
                    <svg class="pagination-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
            </li>
        @else
            <li class="pagination-item">
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link">
                    <svg class="pagination-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($paginator->links()->elements[0] as $page => $url)
            @if ($page == $paginator->currentPage())
                <li class="pagination-item pagination-item-active">
                    <span class="pagination-link">{{ $page }}</span>
                </li>
            @else
                <li class="pagination-item">
                    <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                </li>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="pagination-item">
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link">
                    <svg class="pagination-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </li>
        @else
            <li class="pagination-item pagination-item-disabled">
                <span class="pagination-link">
                    <svg class="pagination-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            </li>
        @endif
    </ul>

    <div class="pagination-info">
        Hiển thị {{ $paginator->firstItem() ?? 0 }} đến {{ $paginator->lastItem() ?? 0 }} trong tổng số {{ $paginator->total() }} kết quả
    </div>
</nav>
@endif
