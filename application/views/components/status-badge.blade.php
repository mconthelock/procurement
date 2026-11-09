@php
    $status = strtolower($status ?? 'neutral');
    $label = $label ?? ucfirst($status);
    $dot = $dot ?? false;
    $size = $size ?? 'sm'; // xs, sm, md, lg

    $sizeClass = match($size) {
        'xs' => 'badge-xs text-[10px]',
        'md' => 'badge-md',
        'lg' => 'badge-lg',
        default => 'badge-sm text-[11px]'
    };

    $badgeVariantClass = match($status) {
        'error', 'danger', 'reject', 'critical', 'overdue' => 'badge-error',
        'warning', 'pending', 'awaiting', 'in_production', 'review' => 'badge-warning',
        'success', 'approved', 'delivered', 'completed', 'active', 'released' => 'badge-success',
        'primary' => 'badge-primary',
        'secondary', 'in_transit' => 'badge-secondary',
        'info' => 'badge-info',
        default => 'badge-neutral'
    };

    $dotColorClass = match($status) {
        'error', 'danger', 'reject', 'critical', 'overdue' => 'bg-error',
        'warning', 'pending', 'awaiting', 'in_production', 'review' => 'bg-warning',
        'success', 'approved', 'delivered', 'completed', 'active', 'released' => 'bg-success',
        'primary' => 'bg-primary-content',
        default => 'bg-base-content'
    };
@endphp

<span class="badge {{ $badgeVariantClass }} {{ $sizeClass }} font-mono font-bold uppercase tracking-wider gap-1">
    @if ($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColorClass }}"></span>
    @endif
    <span>{{ $label }}</span>
</span>
