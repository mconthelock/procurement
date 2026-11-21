@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen mx-auto flex flex-col gap-space-md">
        <input type="hidden" id="vnd-id" value="{{ $id }}">
        <input type="hidden" id="app-env" value="{{ $_ENV['APP_ENV'] }}">

        {{-- Section 0: Breadcrumb & System Status Strip --}}
        @include('layouts/breadcrumb')

        {{-- Section 1: Standard Page Header & Pending Cover Sheet Banner --}}
        @include('vendors/detail/header')

        {{-- Section 2: 4-Tile Vendor Metadata & Monitoring KPI Ribbon --}}
        @include('vendors/detail/summary')

        {{-- Section 3 & 4: Read-Only 6-Tab Vendor Master & Monitoring Profile --}}
        <div class="bg-base-100 shadow-sm border border-base-300 flex flex-col">
            {{-- Corporate Underline Navigation Tabs --}}
            <div class="flex items-center border-b border-base-200 overflow-x-auto px-space-md pt-2 gap-1"
                id="vendorDetailTabs" role="tablist">
                <button type="button" role="tab" aria-selected="true" data-tab="tab-overview"
                    class="vendor-detail-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-bold text-primary border-b-2 border-primary text-nowrap cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">business</span>
                    <span>Overview, Address &amp; Documents</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-tab="tab-financial"
                    class="vendor-detail-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">account_balance</span>
                    <span>Financial &amp; AS400</span>
                    <span id="badge-count-codes" class="badge badge-xs font-mono">0</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-tab="tab-scm"
                    class="vendor-detail-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">group</span>
                    <span>E-SCM Contacts</span>
                    <span id="badge-count-scm" class="badge badge-xs font-mono">0</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-tab="tab-evaluation"
                    class="vendor-detail-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">fact_check</span>
                    <span>Evaluation &amp; Compliance</span>
                    <span id="badge-eval-grade" class="badge badge-xs badge-ghost font-mono">-</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-tab="tab-history"
                    class="vendor-detail-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">history</span>
                    <span>Change History &amp; Monitoring</span>
                    <span id="badge-count-history" class="badge badge-xs font-mono">0</span>
                </button>
            </div>

            {{-- Read-Only Tab Panels --}}
            @include('vendors/detail/tab-overview')
            @include('vendors/detail/tab-financial')
            @include('vendors/detail/tab-scm')
            @include('vendors/detail/tab-evaluation')
            @include('vendors/detail/tab-history')

            {{-- Read-Only Footer Strip --}}
            <div
                class="px-space-lg py-space-md bg-base-200 border-t border-base-300 flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                <div class="flex items-center gap-2 text-xs text-mute font-mono">
                    <span class="material-symbols-outlined text-[16px] text-secondary">verified_user</span>
                    <span>AMEC Vendor Master Registry (PRO-QP-A-020) • Read-Only Official Record</span>
                </div>
                <div class="flex flex-wrap items-center gap-space-sm">
                    <a id="footer-btn-cover-update" href="{{ $_ENV['APP_ENV'] }}/Vendors/create?mode=U&code={{ $id }}"
                        class="btn btn-sm btn-primary gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">edit_document</span>
                        <span>Request Update (Cover Sheet)</span>
                    </a>
                    <a href="{{ $_ENV['APP_ENV'] }}/Vendors"
                        class="btn btn-sm btn-outline border-primary bg-white text-primary gap-1.5">
                        <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                        <span>Back to Vendor Directory</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Section 5: Corporate Operational Directives Banner --}}
        @include('vendors/detail/directives')
    </main>

    {{-- Overlay: Slide-Over Revision Diff Drawer --}}
    @include('vendors/detail/drawer-diff')
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/vendors_detail.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
