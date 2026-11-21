@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen mx-auto flex flex-col gap-space-md">
        <input type="hidden" id="vnd-id" value="{{ $id }}">

        {{-- Section 0: Breadcrumb & System Status Strip --}}
        @include('layouts/breadcrumb')

        {{-- Section 1: Standard Page Header --}}
        @include('vendors/detail/header')

        {{-- Section 2: Vendor Metadata KPI Ribbon --}}
        @include('vendors/detail/summary')

        {{-- Section 3 & 4: Read-Only Tabbed Vendor Master Profile --}}
        <div class="bg-base-100 shadow-sm border border-base-300 flex flex-col">
            {{-- Corporate Underline Navigation Tabs --}}
            <div class="flex items-center border-b border-base-200 overflow-x-auto px-space-md pt-2"
                id="vendorDetailTabs" role="tablist">
                <button type="button" role="tab" aria-selected="true" data-tab="tab-general"
                    class="vendor-detail-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-bold text-primary border-b-2 border-primary text-nowrap cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">business</span>
                    <span>General Info &amp; Attachments</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-tab="tab-codes"
                    class="vendor-detail-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">pin</span>
                    <span>Vendor Codes &amp; Payment</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-tab="tab-address"
                    class="vendor-detail-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">location_on</span>
                    <span>Address Details (EN / TH)</span>
                </button>
            </div>

            {{-- Read-Only Tab Panels --}}
            @include('vendors/detail/tab-general')
            @include('vendors/detail/tab-codes')
            @include('vendors/detail/tab-address')

            {{-- Read-Only Footer Strip --}}
            <div
                class="px-space-lg py-space-md bg-base-200 border-t border-base-300 flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                <div class="flex items-center gap-2 text-xs text-mute font-mono">
                    <span class="material-symbols-outlined text-[16px] text-secondary">verified_user</span>
                    <span>AMEC Vendor Master Registry • Read-Only Official Record</span>
                </div>
                <a href="{{ $_ENV['APP_ENV'] }}/Vendors" class="btn btn-sm btn-outline border-primary bg-white text-primary gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    <span>Back to Vendor Directory</span>
                </a>
            </div>
        </div>

        {{-- Section 5: Corporate Operational Directives Banner --}}
        @include('vendors/detail/directives')
    </main>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/vendors_detail.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
