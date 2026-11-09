@php
    $systemTag = $systemTag ?? 'AMEC-PRO-SYS-TH';
    $alertTag = $alertTag ?? null;
    $title = $title ?? '';
    $description = $description ?? '';
    $actions = $actions ?? ($slot ?? '');
    $actionsList = $actionsList ?? [];
@endphp

<!-- Mitsubishi Electric Standard Page Header Component -->
<div
    class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-space-md bg-base-100 p-space-lg shadow-sm border-b border-base-300">
    <div class="space-y-space-xs max-w-3xl">
        <div class="flex items-center gap-2">
            <span class="badge badge-primary font-mono text-[11px] uppercase tracking-wider font-bold">
                {{ $systemTag }}
            </span>
            @if (!empty($alertTag))
                <span class="text-caption text-error font-bold">
                    {{ $alertTag }}
                </span>
            @endif
        </div>
        <h1 class="font-h1 text-h2 md:text-h1 text-on-surface leading-tight font-bold tracking-tight">
            {{ $title }}
        </h1>
        @if (!empty($description))
            <p class="text-body-md text-text-muted">
                {{ $description }}
            </p>
        @endif
    </div>

    @if (!empty($actions) || !empty($actionsList))
        <div class="flex flex-wrap items-center gap-space-sm shrink-0">
            @if (!empty($actionsList) && is_array($actionsList))
                @foreach ($actionsList as $action)
                    @php
                        $btnVariant = $action['variant'] ?? 'default';
                        $btnVariantClass = match ($btnVariant) {
                            'primary' => 'btn-primary',
                            'secondary' => 'btn-secondary',
                            'accent' => 'btn-accent',
                            'danger', 'error' => 'btn-error',
                            'ghost' => 'btn-ghost',
                            'neutral' => 'btn-neutral',
                            default => 'btn-outline',
                        };
                        $btnClass = "btn btn-sm {$btnVariantClass} gap-1.5";
                    @endphp
                    @if (!empty($action['href']))
                        <a href="{{ $action['href'] }}" class="{{ $btnClass }}">
                            @if (!empty($action['icon']))
                                <span class="material-symbols-outlined text-[18px]">{{ $action['icon'] }}</span>
                            @endif
                            <span>{{ $action['label'] }}</span>
                        </a>
                    @else
                        <button type="{{ $action['type'] ?? 'button' }}"
                            @if (!empty($action['onclick'])) onclick="{{ $action['onclick'] }}" @endif
                            class="{{ $btnClass }}">
                            @if (!empty($action['icon']))
                                <span class="material-symbols-outlined text-[18px]">{{ $action['icon'] }}</span>
                            @endif
                            <span>{{ $action['label'] }}</span>
                        </button>
                    @endif
                @endforeach
            @endif
            {!! $actions !!}
        </div>
    @endif
</div>
