@php
    $tabs = $tabs ?? [];
    $activeTab = $activeTab ?? ($tabs[0]['id'] ?? '');
    $onTabClick = $onTabClick ?? 'switchTab';
    $extra = $extra ?? ($slot ?? '');
@endphp

<!-- DaisyUI Standard Nav Tabs Strip -->
<div class="bg-base-100 shadow-sm px-4 pt-2 flex flex-wrap items-center justify-between gap-2 border-b border-base-300">
    <div class="flex items-center overflow-x-auto scrollbar-none gap-1 sm:gap-2">
        @foreach ($tabs as $tab)
            @php
                $tabId = $tab['id'] ?? '';
                $tabLabel = $tab['label'] ?? '';
                $tabCount = $tab['count'] ?? null;
                $isActive = !empty($tab['active']) || ($activeTab === $tabId);
                $isUrgent = !empty($tab['urgent']);
                $hasDot = !empty($tab['dot']);

                if ($isActive) {
                    $btnClass = 'text-primary border-b-2 border-primary font-bold';
                } elseif ($isUrgent) {
                    $btnClass = 'text-error hover:text-error border-b-2 border-error font-bold';
                } else {
                    $btnClass = 'text-text-muted hover:text-primary border-b-2 border-transparent font-semibold';
                }
            @endphp
            <button type="button"
                @if (!empty($tabId)) data-tab="{{ $tabId }}" @endif
                onclick="{{ $tab['onclick'] ?? $onTabClick . '(\'' . $tabId . '\')' }}"
                class="flex items-center gap-2 px-3 py-2 text-body-sm whitespace-nowrap transition-colors {{ $btnClass }}">
                @if ($hasDot)
                    <span class="w-2 h-2 {{ $tab['dotColor'] ?? ($isUrgent ? 'bg-error' : 'bg-success') }} rounded-full"></span>
                @endif
                <span>{{ $tabLabel }}</span>
                @if ($tabCount !== null)
                    <span class="badge badge-sm {{ $isActive ? 'badge-primary' : ($isUrgent ? 'badge-error' : 'badge-neutral') }} font-mono text-[11px]">
                        {{ $tabCount }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    @if (!empty($extra))
        <div class="flex items-center gap-2 py-2 shrink-0">
            {!! $extra !!}
        </div>
    @endif
</div>
