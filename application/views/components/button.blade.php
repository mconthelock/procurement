@php
    $label = $label ?? ($slot ?? '');
    $variant = $variant ?? 'default';
    $size = $size ?? 'sm';
    $icon = $icon ?? null;
    $iconPosition = $iconPosition ?? 'left';
    $type = $type ?? 'button';
    $href = $href ?? null;
    $onclick = $onclick ?? null;
    $disabled = $disabled ?? false;
    $class = $class ?? '';

    $btnVariantClass = match($variant) {
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'accent' => 'btn-accent',
        'danger', 'error' => 'btn-error',
        'ghost' => 'btn-ghost',
        'neutral' => 'btn-neutral',
        'outline' => 'btn-outline',
        default => 'btn-outline'
    };

    $btnSizeClass = match($size) {
        'xs' => 'btn-xs',
        'md' => 'btn-md',
        'lg' => 'btn-lg',
        default => 'btn-sm'
    };

    $commonClass = "btn {$btnVariantClass} {$btnSizeClass} gap-1.5 {$class}";
@endphp

@if (!empty($href))
    <a href="{{ $href }}"
        @if ($disabled) tabindex="-1" aria-disabled="true" @endif
        class="{{ $commonClass }} {{ $disabled ? 'opacity-40 pointer-events-none' : '' }}">
        @if (!empty($icon) && $iconPosition === 'left')
            <span class="material-symbols-outlined text-[18px]">{{ $icon }}</span>
        @endif
        <span>{!! $label !!}</span>
        @if (!empty($icon) && $iconPosition === 'right')
            <span class="material-symbols-outlined text-[18px]">{{ $icon }}</span>
        @endif
    </a>
@else
    <button type="{{ $type }}"
        @if (!empty($onclick)) onclick="{{ $onclick }}" @endif
        @if ($disabled) disabled @endif
        class="{{ $commonClass }}">
        @if (!empty($icon) && $iconPosition === 'left')
            <span class="material-symbols-outlined text-[18px]">{{ $icon }}</span>
        @endif
        <span>{!! $label !!}</span>
        @if (!empty($icon) && $iconPosition === 'right')
            <span class="material-symbols-outlined text-[18px]">{{ $icon }}</span>
        @endif
    </button>
@endif
