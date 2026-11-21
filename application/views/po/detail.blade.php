@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen mx-auto flex flex-col gap-space-md">
        <input type="hidden" id="po-no" value="{{ $id }}">
        <input type="hidden" id="app-env" value="{{ $_ENV['APP_ENV'] }}">

        {{-- Section 0: Breadcrumb & System Status Strip --}}
        @include('layouts/breadcrumb')

        {{-- Section 1: Standard Page Header & Urgent Alert Banner --}}
        @include('po/detail/header')

        {{-- Section 2: 4-Tile PO Metadata & Delivery KPI Ribbon --}}
        @include('po/detail/summary')

        {{-- Section 3 & 4: Tabbed PO Detail Specification --}}
        <div class="bg-base-100 shadow-sm border border-base-300 flex flex-col">
            {{-- Corporate Underline Navigation Tabs --}}
            <div class="flex items-center border-b border-base-200 overflow-x-auto px-space-md pt-2 gap-1"
                id="poDetailTabs" role="tablist" aria-label="Purchase Order Detail Sections">
                <button type="button" role="tab" aria-selected="true" data-tab="tab-items"
                    class="po-detail-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-sm font-bold text-primary border-b-2 border-primary text-nowrap cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">inventory_2</span>
                    <span>Line Items &amp; Pricing</span>
                    <span id="badge-count-items" class="badge badge-xs badge-primary font-mono">0</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-tab="tab-delivery"
                    class="po-detail-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">local_shipping</span>
                    <span>Supplier, Delivery &amp; ASN</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-tab="tab-history"
                    class="po-detail-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">history</span>
                    <span>Revision &amp; Audit Trail</span>
                    <span id="badge-count-history" class="badge badge-xs badge-ghost font-mono">0</span>
                </button>
            </div>

            {{-- Tab Panels --}}
            @include('po/detail/tab-items')
            @include('po/detail/tab-delivery')
            @include('po/detail/tab-history')

            {{-- Footer Action Strip --}}
            <div
                class="px-space-lg py-space-md bg-base-200 border-t border-base-300 flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                <div class="flex items-center gap-2 text-xs text-mute font-mono">
                    <span class="material-symbols-outlined text-[16px] text-secondary">verified_user</span>
                    <span>AMEC Purchase Order Control (AMEC-PRO-SYS-TH) • Official Electronic Record</span>
                </div>
                <div class="flex flex-wrap items-center gap-space-sm">
                    <button type="button" id="footer-btn-pdf"
                        class="btn btn-sm btn-outline border-primary bg-white text-primary gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                        <span>Download PO PDF</span>
                    </button>
                    <a href="{{ $_ENV['APP_ENV'] }}/orders"
                        class="btn btn-sm btn-primary gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        <span>Back to Purchase Orders</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Section 5: Corporate Operational Directives Banner --}}
        @include('po/index/directives')
    </main>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/po_detail.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
