<!-- Section 3: Status & Item Type Tabs + Precision Filter Strip -->
<div class="bg-base-100 border border-base-300 flex flex-col shadow-sm">
    <!-- Status & Type Navigation Tabs -->
    <div class="flex items-center border-b border-base-200 overflow-x-auto px-space-md pt-2 gap-1" id="itemStatusTabs"
        role="tablist" aria-label="Item Master Filter Tabs">
        <button
            class="item-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-bold text-primary border-b-2 border-primary text-nowrap cursor-pointer"
            data-filter-tab="ALL" type="button" role="tab" aria-selected="true">
            <span>All Items</span>
            <span class="badge badge-xs badge-primary font-mono" data-count="ALL">0</span>
        </button>
        <button
            class="item-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="IM" type="button" role="tab" aria-selected="false">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-success"></span>
                Active (IM)
            </span>
            <span class="badge badge-xs badge-success font-mono" data-count="IM">0</span>
        </button>
        <button
            class="item-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="IZ" type="button" role="tab" aria-selected="false">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-error"></span>
                Inactive (IZ)
            </span>
            <span class="badge badge-xs badge-error font-mono" data-count="IZ">0</span>
        </button>
        <button
            class="item-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="TYPE_1" type="button" role="tab" aria-selected="false">
            <span>Bulk (1)</span>
            <span class="badge badge-xs badge-ghost font-mono" data-count="TYPE_1">0</span>
        </button>
        <button
            class="item-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="TYPE_23" type="button" role="tab" aria-selected="false">
            <span>JOP (2,3)</span>
            <span class="badge badge-xs badge-info font-mono" data-count="TYPE_23">0</span>
        </button>
        <button
            class="item-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="TYPE_A" type="button" role="tab" aria-selected="false">
            <span>Stock (A)</span>
            <span class="badge badge-xs badge-secondary font-mono" data-count="TYPE_A">0</span>
        </button>
        <button
            class="item-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="TYPE_BC" type="button" role="tab" aria-selected="false">
            <span>Subcon (B,C)</span>
            <span class="badge badge-xs badge-warning font-mono" data-count="TYPE_BC">0</span>
        </button>
    </div>

    <!-- Precision Filter Controls (12-Column Grid) -->
    <form id="form-filter" class="p-space-md bg-base-100 grid grid-cols-1 md:grid-cols-12 gap-space-sm items-center">
        <div class="md:col-span-3">
            <label
                class="input input-sm border border-base-300 bg-base-100 flex items-center gap-2 focus-within:border-accent h-9.5 w-full">
                <span class="material-symbols-outlined text-[18px] text-mute shrink-0">search</span>
                <input id="purcode" type="text" placeholder="Purcode / Item No. (e.g. KA517B...)"
                    class="grow text-xs font-mono text-primary placeholder:text-mute outline-none border-none focus:outline-none" />
            </label>
        </div>

        <div class="md:col-span-2">
            <label
                class="input input-sm border border-base-300 bg-base-100 flex items-center gap-2 focus-within:border-accent h-9.5 w-full">
                <span class="material-symbols-outlined text-[16px] text-mute shrink-0">architecture</span>
                <input id="drawing" type="text" placeholder="Drawing / Formula #"
                    class="grow text-xs font-mono text-primary placeholder:text-mute outline-none border-none focus:outline-none" />
            </label>
        </div>

        <div class="md:col-span-2">
            <label
                class="input input-sm border border-base-300 bg-base-100 flex items-center gap-2 focus-within:border-accent h-9.5 w-full">
                <span class="material-symbols-outlined text-[16px] text-mute shrink-0">description</span>
                <input id="partname" type="text" placeholder="Part Name / Desc..."
                    class="grow text-xs text-primary placeholder:text-mute outline-none border-none focus:outline-none" />
            </label>
        </div>

        <div class="md:col-span-2">
            <select id="planner"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                <option value="">All Planners (IBUYC)</option>
            </select>
        </div>

        <div class="md:col-span-2">
            <select id="country"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                <option value="">All Origin Countries</option>
            </select>
        </div>

        <div class="md:col-span-1 flex items-center gap-1">
            <button id="btn-search" class="btn btn-sm btn-primary flex-1 h-9.5 px-2 flex items-center justify-center"
                title="Search Items" type="submit">
                <span class="material-symbols-outlined text-[18px]">search</span>
            </button>
            <button id="reset-filter"
                class="btn btn-sm btn-outline border-base-300 h-9.5 px-2 flex items-center justify-center"
                title="Reset Filters" type="button">
                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
            </button>
        </div>
    </form>
</div>
