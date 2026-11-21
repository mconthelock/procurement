<!-- Section 4: Enterprise Vendor Data Table -->
<div class="bg-base-100 shadow-sm overflow-hidden border border-base-300">
    <!-- Table Header Status Bar -->
    <div
        class="px-space-md py-2.5 bg-base-100 border-b border-base-200 flex flex-wrap items-center justify-between gap-space-sm text-xs">
        <div class="flex items-center gap-space-md text-mute">
            <span>Active View: <strong class="text-primary font-mono" id="activeViewSummary">Loading Vendor records...</strong></span>
        </div>
        <div class="flex items-center gap-space-sm">
            <span class="text-mute">Selected: <strong class="text-primary font-mono" id="selectedCounter">0 items</strong></span>
            <button class="hidden btn btn-xs btn-primary gap-1" id="btn-merge-selected" type="button">
                <span class="material-symbols-outlined text-[14px]">hub</span>
                <span>Merge Selected into Group</span>
            </button>
            <button class="link link-hover text-info font-semibold cursor-pointer" id="selectAllPageBtn" type="button">
                Select All On Page
            </button>
        </div>
    </div>

    <!-- Responsive DataTable Container -->
    <div class="overflow-x-auto">
        <table id="table" class="table table-xs w-full border-collapse text-left"></table>
    </div>
</div>
