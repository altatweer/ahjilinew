@if ($paginator->hasPages())
    <nav class="pagination-wrapper" aria-label="{{ __('Pagination Navigation') }}">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">
                        <i class="bi bi-chevron-right me-1"></i>
                        السابق
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="bi bi-chevron-right me-1"></i>
                        السابق
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        التالي
                        <i class="bi bi-chevron-left ms-1"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">
                        التالي
                        <i class="bi bi-chevron-left ms-1"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif

<style>
.pagination-wrapper {
    margin: 2rem 0;
}

.pagination {
    --bs-pagination-padding-x: 1rem;
    --bs-pagination-padding-y: 0.5rem;
    --bs-pagination-font-size: 1rem;
    --bs-pagination-color: #5C7D99;
    --bs-pagination-bg: #fff;
    --bs-pagination-border-width: 1px;
    --bs-pagination-border-color: #dee2e6;
    --bs-pagination-border-radius: 10px;
    --bs-pagination-hover-color: #fff;
    --bs-pagination-hover-bg: #5C7D99;
    --bs-pagination-hover-border-color: #5C7D99;
    --bs-pagination-focus-color: #fff;
    --bs-pagination-focus-bg: #5C7D99;
    --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(92, 125, 153, 0.25);
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: #5C7D99;
    --bs-pagination-active-border-color: #5C7D99;
    --bs-pagination-disabled-color: #6c757d;
    --bs-pagination-disabled-bg: #fff;
    --bs-pagination-disabled-border-color: #dee2e6;
}

.page-link {
    display: flex;
    align-items: center;
    font-weight: 500;
    transition: all 0.3s ease;
}

.page-link:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(92, 125, 153, 0.2);
}

.page-item.active .page-link {
    background-color: var(--bs-pagination-active-bg);
    border-color: var(--bs-pagination-active-border-color);
    color: var(--bs-pagination-active-color);
    font-weight: 600;
}

.page-item.disabled .page-link {
    opacity: 0.5;
}

.page-item:first-child .page-link {
    border-top-left-radius: var(--bs-pagination-border-radius);
    border-bottom-left-radius: var(--bs-pagination-border-radius);
}

.page-item:last-child .page-link {
    border-top-right-radius: var(--bs-pagination-border-radius);
    border-bottom-right-radius: var(--bs-pagination-border-radius);
}

@media (max-width: 576px) {
    .pagination {
        --bs-pagination-padding-x: 0.75rem;
        --bs-pagination-padding-y: 0.375rem;
        --bs-pagination-font-size: 0.875rem;
    }
    
    .page-link {
        gap: 0.25rem;
    }
}
</style>
