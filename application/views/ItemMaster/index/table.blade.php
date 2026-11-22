<!-- Section 4: Enterprise Item Master Data Table -->
<div class="bg-base-100 shadow-sm overflow-hidden border border-base-300">
    <!-- Table Header Status Bar -->
    <div
        class="px-space-md py-2.5 bg-base-100 border-b border-base-200 flex flex-wrap items-center justify-between gap-space-sm text-xs">
        <div class="flex items-center gap-space-md text-mute">
            <span>Active View: <strong class="text-primary font-mono" id="activeViewSummary">Loading Item Master
                    records...</strong></span>
            <span id="dataSourceBadge" class="hidden badge badge-xs badge-warning font-mono uppercase">Preview Sample
                Data</span>
        </div>
        <div class="flex items-center gap-2 text-mute font-mono text-[11px]">
            <span class="material-symbols-outlined text-[15px] text-secondary">database</span>
            <span>AS400 / BPCS Table: AMECMFG.IIM</span>
        </div>
    </div>

    <!-- Responsive DataTable Container -->
    <div class="overflow-x-auto">
        <table id="table" class="table table-xs w-full border-collapse text-left"></table>
    </div>
</div>
