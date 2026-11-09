@php
    $currentPage = (int)($currentPage ?? 1);
    $totalPages = (int)($totalPages ?? 5);
    $totalRecords = (int)($totalRecords ?? 42);
    $perPage = (int)($perPage ?? 10);
    $from = ($currentPage - 1) * $perPage + 1;
    $to = min($currentPage * $perPage, $totalRecords);
    $perPageOptions = $perPageOptions ?? [10, 20, 50, 100];
    $onPageChange = $onPageChange ?? 'changePage';
    $onPerPageChange = $onPerPageChange ?? 'changePerPage';
    $entityLabel = $entityLabel ?? 'records';
@endphp

<!-- DaisyUI Standard Table Pagination Component -->
<div class="p-space-md bg-base-200 border-t border-base-300 flex flex-col sm:flex-row items-center justify-between gap-space-md text-caption">
    <!-- Left: Records Info & Per-Page Selector -->
    <div class="flex flex-wrap items-center gap-2 text-text-muted">
        <span>Showing <strong class="text-primary">{{ $from }} - {{ $to }}</strong> of <strong class="text-primary">{{ $totalRecords }}</strong> {{ $entityLabel }}</span>
        <span class="text-base-300 hidden sm:inline-block">|</span>
        <span class="hidden sm:inline-block">Rows per page:</span>
        <select onchange="{{ $onPerPageChange }}(this.value)"
            class="select select-xs select-bordered bg-base-100 text-primary border-base-300 focus:outline-none">
            @foreach ($perPageOptions as $option)
                <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>{{ $option }}</option>
            @endforeach
        </select>
    </div>

    <!-- Right: Page Controls -->
    <div class="join">
        <!-- First Page -->
        <button type="button"
            onclick="{{ $onPageChange }}(1)"
            class="join-item btn btn-xs btn-outline border-base-300"
            {{ $currentPage <= 1 ? 'disabled' : '' }}
            title="First Page">
            <span class="material-symbols-outlined text-[16px]">first_page</span>
        </button>

        <!-- Previous Page -->
        <button type="button"
            onclick="{{ $onPageChange }}({{ max(1, $currentPage - 1) }})"
            class="join-item btn btn-xs btn-outline border-base-300"
            {{ $currentPage <= 1 ? 'disabled' : '' }}
            title="Previous Page">
            <span class="material-symbols-outlined text-[16px]">chevron_left</span>
        </button>

        <!-- Dynamic Page Numbers -->
        @php
            $startPage = max(1, $currentPage - 2);
            $endPage = min($totalPages, $startPage + 4);
            if ($endPage - $startPage < 4) {
                $startPage = max(1, $endPage - 4);
            }
        @endphp

        @if ($startPage > 1)
            <button type="button" onclick="{{ $onPageChange }}(1)"
                class="join-item btn btn-xs btn-outline border-base-300">
                1
            </button>
            @if ($startPage > 2)
                <span class="join-item btn btn-xs btn-disabled bg-base-200 border-base-300 text-text-muted">...</span>
            @endif
        @endif

        @for ($page = $startPage; $page <= $endPage; $page++)
            @if ($page === $currentPage)
                <button type="button"
                    class="join-item btn btn-xs btn-primary font-bold">
                    {{ $page }}
                </button>
            @else
                <button type="button" onclick="{{ $onPageChange }}({{ $page }})"
                    class="join-item btn btn-xs btn-outline border-base-300">
                    {{ $page }}
                </button>
            @endif
        @endfor

        @if ($endPage < $totalPages)
            @if ($endPage < $totalPages - 1)
                <span class="join-item btn btn-xs btn-disabled bg-base-200 border-base-300 text-text-muted">...</span>
            @endif
            <button type="button" onclick="{{ $onPageChange }}({{ $totalPages }})"
                class="join-item btn btn-xs btn-outline border-base-300">
                {{ $totalPages }}
            </button>
        @endif

        <!-- Next Page -->
        <button type="button"
            onclick="{{ $onPageChange }}({{ min($totalPages, $currentPage + 1) }})"
            class="join-item btn btn-xs btn-outline border-base-300"
            {{ $currentPage >= $totalPages ? 'disabled' : '' }}
            title="Next Page">
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        </button>

        <!-- Last Page -->
        <button type="button"
            onclick="{{ $onPageChange }}({{ $totalPages }})"
            class="join-item btn btn-xs btn-outline border-base-300"
            {{ $currentPage >= $totalPages ? 'disabled' : '' }}
            title="Last Page">
            <span class="material-symbols-outlined text-[16px]">last_page</span>
        </button>
    </div>
</div>
