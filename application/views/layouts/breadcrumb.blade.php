@php
    $crumbs = $breadcrumbs ?? ($items ?? []);
    if (empty($crumbs) && function_exists('get_instance')) {
        $ci = &get_instance();
        if (isset($ci->breadcrumb)) {
            $crumbs = $ci->breadcrumb->getItems();
        }
    }
    $statusData = $breadcrumb_status ?? ($status ?? []);
    if (empty($statusData) && function_exists('get_instance')) {
        $ci = &get_instance();
        if (isset($ci->breadcrumb)) {
            $statusData = $ci->breadcrumb->getStatus();
        }
    }
    $showStatus = isset($statusData['show']) ? $statusData['show'] : true;
@endphp

@if (!empty($crumbs))
    <div class="w-full py-3 pl-2">
        <div class="max-w-container-content mx-auto flex flex-wrap items-center justify-between gap-y-2">
            <nav aria-label="Breadcrumb" class="breadcrumbs p-0   text-secondary">
                <ul>
                    @foreach ($crumbs as $index => $crumb)
                        @php
                            $title = is_array($crumb) ? $crumb['title'] ?? '' : (string) $crumb;
                            $url = is_array($crumb) ? $crumb['url'] ?? '' : '';
                            $icon = is_array($crumb) ? $crumb['icon'] ?? '' : '';
                            $isLast = $index === count($crumbs) - 1 || !empty($crumb['is_active']);
                        @endphp
                        <li>
                            @if (!$isLast && !empty($url))
                                <a class="hover:text-primary transition-colors flex items-center gap-1"
                                    href="{{ $url }}">
                                    <span class="material-symbols-outlined text-[16px]">{{ $icon }}</span>
                                    <span class="text-xs">{{ $title }}</span>
                                </a>
                            @else
                                <span class="text-primary font-bold flex items-center gap-1" aria-current="page">
                                    <span
                                        class="material-symbols-outlined text-[16px] {{ !isset($icon) || $icon === '' ? 'hidden' : '' }}">{{ $icon }}</span>
                                    <span class="text-xs">{{ $title }}</span>
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>

            @if ($showStatus)
                <div class="hidden sm:flex items-center gap-3 font-mono text-xs">
                    <span
                        class="inline-block w-2 h-2 rounded-full {{ $statusData['dot_class'] ?? 'bg-success' }}"></span>
                    <span>{{ $statusData['text'] ?? 'Status: Normal' }}</span>
                    @if (!empty($statusData['code']))
                        <span class="text-outline-variant">|</span>
                        <span>{{ $statusData['code'] }}</span>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endif
