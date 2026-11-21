<!-- Section 4: Enterprise Vendor Users Data Table -->
<div class="bg-base-100 shadow-sm overflow-hidden border border-base-300">
    <!-- Table Header Status Bar -->
    <div
        class="px-space-md py-2.5 bg-base-100 border-b border-base-200 flex flex-wrap items-center justify-between gap-space-sm text-xs">
        <div class="flex items-center gap-space-md text-mute">
            <span>Active View: <strong class="text-primary" id="active-view-summary">Showing 0 of 0 User
                    accounts</strong></span>
            <span class="w-px h-3 bg-base-300 hidden sm:inline-block"></span>
            <span class="flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px] text-secondary">verified_user</span>
                Role-Based Portal Access Active
            </span>
        </div>
        <div class="flex items-center gap-space-sm">
            <span class="text-mute">Selected: <strong class="text-primary" id="selected-counter">0
                    items</strong></span>
            <button class="link link-hover text-info font-semibold cursor-pointer" id="select-all-users-btn"
                type="button">
                Select All On Page
            </button>
        </div>
    </div>

    <!-- Responsive DataTable -->
    <div class="overflow-x-auto">
        <table id="table" class="table table-sm w-full border-collapse text-left"></table>
    </div>
</div>
