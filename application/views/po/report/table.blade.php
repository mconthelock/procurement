<!-- Section 4: Enterprise Search Results Data Table -->
<div class="bg-base-100 shadow-sm overflow-hidden border border-base-300">
    <!-- Table Header Status Bar -->
    <div
        class="px-space-md py-2.5 bg-base-100 border-b border-base-200 flex flex-wrap items-center justify-between gap-space-sm text-xs">
        <div class="flex flex-wrap items-center gap-space-md text-mute">
            <span>Query Result: <strong class="text-primary" id="rpt-active-summary">Showing 0 of 0
                    records</strong></span>
            <span class="w-px h-3 bg-base-300 hidden sm:inline-block"></span>
            <span class="flex items-center gap-1 font-mono">
                <span class="material-symbols-outlined text-[14px] text-secondary">table_chart</span>
                <span id="rpt-mode-label">Mode: PO Header</span>
            </span>
        </div>

        <div class="flex items-center gap-space-sm w-full sm:w-auto">
            <label
                class="input input-xs border border-base-300 bg-base-100 flex items-center gap-1.5 focus-within:border-accent w-full sm:w-64 h-8">
                <span class="material-symbols-outlined text-[15px] text-mute shrink-0">filter_alt</span>
                <input id="rpt-quick-filter" type="text" placeholder="Filter within results..."
                    class="grow text-xs text-primary placeholder:text-mute outline-none border-none focus:outline-none" />
            </label>
        </div>
    </div>

    <!-- Responsive DataTable -->
    <div class="overflow-x-auto" tabindex="0" role="region" aria-label="Purchase Order Report Results">
        <table id="table" class="table table-xs w-full border-collapse text-left"></table>
    </div>
</div>
