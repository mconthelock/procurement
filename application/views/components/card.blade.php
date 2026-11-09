@php
    $title = $title ?? '';
    $subtitle = $subtitle ?? '';
    $icon = $icon ?? null;
    $badge = $badge ?? null;
    $badgeClass = $badgeClass ?? 'badge-neutral';
    $borderTop = $borderTop ?? null;
    $actions = $actions ?? null;
    $class = $class ?? '';
    $bodyClass = $bodyClass ?? '';

    $borderTopClass = match($borderTop) {
        'primary' => 'border-t-2 border-primary',
        'error', 'danger' => 'border-t-2 border-error',
        'warning' => 'border-t-2 border-warning',
        'success' => 'border-t-2 border-success',
        'secondary' => 'border-t-2 border-secondary',
        default => ''
    };
@endphp

<!-- DaisyUI Standard Card Component -->
<div class="card bg-base-100 border border-base-300 shadow-sm {{ $borderTopClass }} {{ $class }}">
    @if (!empty($title) || !empty($actions) || !empty($badge))
        <div class="px-4 py-3 border-b border-base-300 flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                @if (!empty($icon))
                    <span class="material-symbols-outlined text-[20px] text-primary">{{ $icon }}</span>
                @endif
                <div>
                    <h2 class="card-title text-base font-bold text-primary m-0">
                        {{ $title }}
                    </h2>
                    @if (!empty($subtitle))
                        <p class="text-xs text-text-muted m-0">{{ $subtitle }}</p>
                    @endif
                </div>
                @if (!empty($badge))
                    <span class="badge badge-sm {{ $badgeClass }} font-mono font-bold">
                        {{ $badge }}
                    </span>
                @endif
            </div>

            @if (!empty($actions))
                <div class="card-actions items-center gap-2">
                    {!! $actions !!}
                </div>
            @endif
        </div>
    @endif

    <div class="card-body p-4 {{ $bodyClass }}">
        {!! $slot ?? '' !!}
    </div>
</div>
