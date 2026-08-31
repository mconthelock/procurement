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
    <section
        class="grid gap-4 xl:grid-cols-[1fr_auto] xl:items-end rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
            <label class="form-control w-full" id="requirements-assignee-filter-wrap">
                <div class="label pb-2">
                    <span class="label-text text-xs font-semibold uppercase tracking-wide text-slate-500">Search</span>
                </div>
                <input id="table-search" type="text" class="input input-bordered w-full" placeholder="Search...">
            </label>

            <label class="form-control w-full" for="table-status-filter">
                <div class="label pb-2">
                    <span class="label-text text-xs font-semibold uppercase tracking-wide text-slate-500">Status</span>
                </div>
                <select id="table-status-filter" class="select select-bordered w-full s2">
                </select>
            </label>
            <label class="form-control w-full" for="table-country-filter">
                <div class="label pb-2">
                    <span class="label-text text-xs font-semibold uppercase tracking-wide text-slate-500">Country</span>
                </div>
                <select id="table-country-filter" class="select select-bordered w-full s2">
                </select>
            </label>
        </div>
        <div class="flex items-center gap-3">
            <button id="reset-filter" class="btn btn-soft" type="button"><i
                    class="fi fi-br-rotate-right text-xl"></i>Reset Filters</button>

        </div>
    </section>

    {{-- Datatable --}}
    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm min-h-[60vh]">
        <table id="table" class="table table-zebra display text-xs"></table>
    </section>
</div>

@endsection

@section('scripts')
<script src="{{ $_ENV['APP_JS'] }}/ItemMaster.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection