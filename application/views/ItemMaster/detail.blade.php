@extends('layouts/template')

@section('contents')
    <main class="w-full min-h-screen mx-auto flex flex-col gap-space-md">
        <input type="hidden" id="item-prod-id" value="{{ $id }}">
        <input type="hidden" id="app-env" value="{{ $_ENV['APP_ENV'] }}">

        {{-- Section 0: Breadcrumb & System Status Strip --}}
        @include('layouts/breadcrumb')

        {{-- Section 1: Operational Sync Strip & Hero Part Header --}}
        @include('ItemMaster/detail/header')

        {{-- Section 2: 4-Tile Item Master KPI Ribbon --}}
        @include('ItemMaster/detail/summary')

        {{-- Section 3 & 4: 12-Column Main Body (8-Col Tabbed Technical Dossier + 4-Col Supporting Sidebar) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-space-md items-start">
            {{-- Left Column: 5-Tab IIM Technical & ERP Dossier (8 cols) --}}
            <div class="lg:col-span-8 bg-base-100 shadow-sm border border-base-300 flex flex-col">
                {{-- Corporate Underline Navigation Tabs --}}
                <div class="flex items-center border-b border-base-200 overflow-x-auto px-space-md pt-2 gap-1"
                    id="itemDetailTabs" role="tablist" aria-label="Item Master Detail Sections">
                    <button type="button" role="tab" aria-selected="true" data-tab="tab-specs"
                        class="item-detail-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-xs font-bold uppercase tracking-wider text-primary border-b-2 border-primary text-nowrap cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">menu_book</span>
                        <span>01. Specs &amp; Physical</span>
                    </button>
                    <button type="button" role="tab" aria-selected="false" data-tab="tab-inventory"
                        class="item-detail-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-xs font-semibold uppercase tracking-wider text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">warehouse</span>
                        <span>02. Inventory &amp; Activity</span>
                    </button>
                    <button type="button" role="tab" aria-selected="false" data-tab="tab-costing"
                        class="item-detail-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-xs font-semibold uppercase tracking-wider text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">payments</span>
                        <span>03. Costing &amp; Valuation</span>
                    </button>
                    <button type="button" role="tab" aria-selected="false" data-tab="tab-planning"
                        class="item-detail-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-xs font-semibold uppercase tracking-wider text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">schedule</span>
                        <span>04. Planning &amp; MRP</span>
                    </button>
                    <button type="button" role="tab" aria-selected="false" data-tab="tab-procurement"
                        class="item-detail-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-xs font-semibold uppercase tracking-wider text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">corporate_fare</span>
                        <span>05. Procurement &amp; Origin</span>
                    </button>
                </div>

                {{-- Tab Panels --}}
                @include('ItemMaster/detail/tab-specs')
                @include('ItemMaster/detail/tab-inventory')
                @include('ItemMaster/detail/tab-costing')
                @include('ItemMaster/detail/tab-planning')
                @include('ItemMaster/detail/tab-procurement')

                {{-- Footer Action Strip --}}
                <div
                    class="px-space-lg py-space-md bg-base-200 border-t border-base-300 flex flex-col sm:flex-row sm:items-center justify-between gap-space-sm">
                    <div class="flex items-center gap-2 text-xs text-mute font-mono">
                        <span class="material-symbols-outlined text-[16px] text-secondary">verified_user</span>
                        <span>AMEC Item Master (AMECMFG.IIM) • Official ERP Record</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-space-sm">
                        <button type="button" id="footer-btn-print"
                            class="btn btn-sm btn-outline border-primary bg-base-100 text-primary gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">print</span>
                            <span>Print Spec Sheet</span>
                        </button>
                        <a href="{{ $_ENV['APP_ENV'] }}/ItemMaster" class="btn btn-sm btn-primary gap-1.5">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                            <span>Back to Item Catalog</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Column: Lateral Supporting Sidebar (4 cols) --}}
            @include('ItemMaster/detail/sidebar')
        </div>

        {{-- Section 5: Corporate Operational Directives Banner --}}
        @include('ItemMaster/index/directives')
    </main>
@endsection

@section('scripts')
    <script src="{{ $_ENV['APP_JS'] }}/ItemMaster_detail.js?ver={{ $GLOBALS['version'] }}"></script>
@endsection
