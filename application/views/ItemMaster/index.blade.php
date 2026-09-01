@extends('layouts/template')

@section('styles')
<link rel="stylesheet" href="{{ $_ENV['APP_CDN'] }}/icofont/icofont.min.css">
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
                <input id="purcode" type="text" class="input input-bordered w-full" placeholder="e.g. A6330">
            </label>

            <label class="fieldset w-full" for="partname">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Part name
                </legend>
                <input id="partname" type="text" class="input input-bordered w-full" placeholder="e.g. FLAT BAR SS400">
            </label>
            <label class="fieldset w-full" for="country">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Country
                </legend>
                <select id="country" class="select select-bordered w-full s2" placeholder="Select country">
                </select>
            </label>
            <label class="fieldset w-full" for="buyer">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Buyer
                </legend>
                <select id="buyer" class="select select-bordered w-full s2" placeholder="Select buyer">
                </select>
            </label>
            <label class="fieldset w-full" for="status">
                <legend class="fieldset-legend text-xs font-semibold uppercase tracking-wide text-slate-500">Status
                </legend>
                <select id="status" class="select select-bordered w-full s2" placeholder="Select status">
                </select>
            </label>
        </div>
        <div class="flex items-center gap-3">
            <button id="btn-search" class="btn btn-primary" type="submit"><i
                    class="fi fi-br-search text-xl"></i>Search</button>
            <button id="reset-filter" class="btn btn-soft" type="button"><i
                    class="fi fi-br-rotate-right text-xl"></i>Reset Filters</button>
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