@php
    $title = $title ?? '';
    $value = $value ?? '0';
    $unit = $unit ?? '';
    $secondaryValue = $secondaryValue ?? null;
    $icon = $icon ?? null;
    $variant = $variant ?? 'default';
    $badge = $badge ?? null;
    $badgeVariant = $badgeVariant ?? 'error';
    $footerText = $footerText ?? null;
    $footerTrend = $footerTrend ?? null;
    $footerTrendType = $footerTrendType ?? 'up';
    $link = $link ?? null;
    $linkText = $linkText ?? 'Review List';

    $borderTopClass = match($variant) {
        'primary' => 'border-t-2 border-primary',
        'error', 'danger', 'reject' => 'border-t-2 border-error',
        'warning', 'pending' => 'border-t-2 border-warning',
        'success' => 'border-t-2 border-success',
        'secondary' => 'border-t-2 border-secondary',
        default => 'border-t-2 border-base-300'
    };

    $valueColorClass = match($variant) {
        'error', 'danger', 'reject' => 'text-error',
        'warning', 'pending' => 'text-warning',
        default => 'text-primary'
    };

    $badgeClass = match($badgeVariant) {
        'warning', 'pending' => 'badge-warning',
        'success' => 'badge-success',
        'neutral' => 'badge-neutral',
        default => 'badge-error'
    };
@endphp

<div class="card bg-base-100 p-4 shadow-sm border border-base-300 relative flex flex-col justify-between {{ $borderTopClass }}">
    <div>
        <div class="flex items-center justify-between text-text-muted">
            <span class="text-caption uppercase tracking-wider font-bold">
                {{ $title }}
            </span>
            @if (!empty($badge))
                <span class="badge badge-sm {{ $badgeClass }} font-mono font-bold">
                    {{ $badge }}
                </span>
            @elseif (!empty($icon))
                <span class="material-symbols-outlined text-[20px] {{ $variant === 'error' ? 'text-error' : 'text-text-muted' }}">
                    {{ $icon }}
                </span>
            @endif
        </div>

        <div class="mt-2 flex items-baseline justify-between">
            <div class="text-h2 font-bold {{ $valueColorClass }}">
                {{ $value }}
                @if (!empty($unit))
                    <span class="text-body-sm text-text-muted font-normal ml-1">{{ $unit }}</span>
                @endif
            </div>
            @if (!empty($secondaryValue))
                <div class="font-mono text-body-sm text-secondary font-semibold">
                    {{ $secondaryValue }}
                </div>
            @endif
        </div>
    </div>

    @if (!empty($footerText) || !empty($footerTrend) || !empty($link) || !empty($slot))
        <div class="mt-2 pt-2 border-t border-base-200 flex items-center justify-between text-caption text-text-muted">
            @if (!empty($footerText))
                <span>{{ $footerText }}</span>
            @endif

            @if (!empty($footerTrend))
                <span class="{{ $footerTrendType === 'down' ? 'text-error' : 'text-success' }} font-semibold flex items-center gap-0.5">
                    <span class="material-symbols-outlined text-[14px]">
                        {{ $footerTrendType === 'down' ? 'trending_down' : 'trending_up' }}
                    </span>
                    {{ $footerTrend }}
                </span>
            @endif

            @if (!empty($link))
                <a href="{{ $link }}" class="text-secondary hover:underline font-semibold flex items-center gap-1">
                    {{ $linkText }}
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            @endif

            @if (!empty($slot))
                {!! $slot !!}
            @endif
        </div>
    @endif
</div>
