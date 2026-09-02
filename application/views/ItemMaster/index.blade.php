@extends('layouts/template')

@section('styles')
<link rel="stylesheet" href="{{ $_ENV['APP_CDN'] }}/icofont/icofont.min.css">
<style>
    #sales-info td:not(:last-child),
    #sales-info th:not(:last-child) {
        border-right-color:
            color-mix(in oklab, var(--color-base-300), #00000036);
        border-right-width: 1px;
    }
</style>
@endsection

@section('contents')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-base-content">Item master</h1>
        <p class="text-base-content/70">Master data for item management.</p>
    </div>
</div>
<div class="space-y-6">
    <form id="form-filter" class="flex flex-col gap-5 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <label class="fieldset w-full" for="purcode">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Purcode
                </legend>
                <input id="purcode" type="text" class="input input-bordered w-full" placeholder="e.g. A6330" disabled>
            </label>
            <label class="fieldset w-full" for="drawing">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Drawing
                </legend>
                <input id="drawing" type="text" class="input input-bordered w-full" placeholder="e.g. A6330" disabled>
            </label>
            <label class="fieldset w-full" for="partname">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Part name
                </legend>
                <input id="partname" type="text" class="input input-bordered w-full" placeholder="e.g. FLAT BAR SS400"
                    disabled>
            </label>
            <label class="fieldset w-full" for="country">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Country
                </legend>
                <select id="country" class="select select-bordered w-full s2" placeholder="Select country" disabled>
                </select>
            </label>
            <label class="fieldset w-full" for="planner">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Planner
                </legend>
                <select id="planner" class="select select-bordered w-full s2" placeholder="Select planner" disabled>
                </select>
            </label>
            <label class="fieldset w-full" for="status">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Status
                </legend>
                <select id="status" class="select select-bordered w-full s2" placeholder="Select status" disabled>
                </select>
            </label>
        </div>
        <div class="flex items-center gap-3">
            <button id="btn-search" class="btn btn-primary" type="submit" disabled><i
                    class="fi fi-br-search text-xl"></i>Search</button>
            <button id="reset-filter" class="btn btn-soft" type="button" disabled><i
                    class="fi fi-br-rotate-right text-xl"></i>Reset Filters</button>
            <button id="origin-bulk-list" class="btn btn-success ml-auto" type="button" disabled><i
                    class="fi fi-rr-file-excel text-xl"></i>Country of Origin (BULK List)</button>
        </div>
    </form>

    {{-- Datatable --}}
    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm min-h-[60vh]">
        <table id="table" class="table table-zebra display text-xs"></table>
    </section>
</div>

@endsection

@section('scripts')
<script src="{{ $_ENV['APP_JS'] }}/ItemMaster.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection