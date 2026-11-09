@php
    $placeholder = $placeholder ?? 'Search...';
    $id = $id ?? null;
    $name = $name ?? null;
    $value = $value ?? '';
    $icon = $icon ?? 'search';
    $class = $class ?? '';
    $inputClass = $inputClass ?? '';
    $oninput = $oninput ?? null;
    $onkeyup = $onkeyup ?? null;
    $onchange = $onchange ?? null;
@endphp

<!-- DaisyUI Standard Search Input -->
<label class="input input-sm border border-base-300 bg-base-100 flex items-center gap-2 focus-within:border-accent {{ $class }}">
    @if (!empty($icon))
        <span class="material-symbols-outlined text-[18px] text-text-muted shrink-0">{{ $icon }}</span>
    @endif
    <input type="text"
        @if (!empty($id)) id="{{ $id }}" @endif
        @if (!empty($name)) name="{{ $name }}" @endif
        @if (!empty($value)) value="{{ $value }}" @endif
        @if (!empty($oninput)) oninput="{{ $oninput }}" @endif
        @if (!empty($onkeyup)) onkeyup="{{ $onkeyup }}" @endif
        @if (!empty($onchange)) onchange="{{ $onchange }}" @endif
        placeholder="{{ $placeholder }}"
        class="grow text-body-sm text-primary placeholder:text-text-muted outline-none border-none focus:outline-none focus:ring-0 {{ $inputClass }}" />
    {{ $slot ?? '' }}
</label>
