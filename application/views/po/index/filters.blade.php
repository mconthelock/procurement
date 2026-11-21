<!-- Section 3: Status Navigation Tabs & Precision Filter Strip -->
<div class="bg-base-100 shadow-sm border border-base-300 flex flex-col">
    <!-- Status Navigation Tabs -->
    <div class="flex items-center border-b border-base-200 overflow-x-auto px-space-md pt-2" id="poStatusTabs"
        role="tablist" aria-label="Purchase Order Status Filters">
        <button
            class="po-status-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-sm font-bold text-primary border-b-2 border-primary text-nowrap cursor-pointer"
            data-status="" type="button" role="tab" aria-selected="true">
            <span>All Purchase Orders</span>
            <span class="badge badge-xs badge-primary font-mono" id="tab-count-all">0</span>
        </button>
        <button
            class="po-status-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-status="AWAITING_CONFIRMATION" type="button" role="tab" aria-selected="false">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-error"></span>
                Awaiting Confirmation
            </span>
            <span class="badge badge-xs badge-error font-mono font-bold" id="tab-count-awaiting">0</span>
        </button>
        <button
            class="po-status-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-status="IN_PRODUCTION" type="button" role="tab" aria-selected="false">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-warning"></span>
                In Production
            </span>
            <span class="badge badge-xs badge-warning font-mono font-bold" id="tab-count-production">0</span>
        </button>
        <button
            class="po-status-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-status="READY_TO_SHIP" type="button" role="tab" aria-selected="false">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-success"></span>
                Ready to Ship
            </span>
            <span class="badge badge-xs badge-success font-mono font-bold" id="tab-count-ready">0</span>
        </button>
        <button
            class="po-status-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-status="IN_TRANSIT" type="button" role="tab" aria-selected="false">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-info"></span>
                In Transit (ASN Active)
            </span>
            <span class="badge badge-xs badge-info font-mono font-bold" id="tab-count-transit">0</span>
        </button>
        <button
            class="po-status-tab shrink-0 flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-status="DELIVERED" type="button" role="tab" aria-selected="false">
            <span>Delivered / Completed</span>
            <span class="badge badge-xs badge-ghost font-mono" id="tab-count-delivered">0</span>
        </button>
    </div>

    <!-- Advanced Filter Form Controls (12-Column Grid) -->
    <div class="p-space-md bg-base-100 grid grid-cols-1 md:grid-cols-12 gap-space-sm items-center">
        <div class="md:col-span-4">
            <label
                class="input input-sm border border-base-300 bg-base-100 flex items-center gap-2 focus-within:border-accent h-9.5 w-full">
                <span class="material-symbols-outlined text-[18px] text-mute shrink-0">search</span>
                <input id="po-search" type="text"
                    placeholder="Search PO #, Vendor, Part No., Description, Plant..."
                    class="grow text-sm text-primary placeholder:text-mute outline-none border-none focus:outline-none" />
            </label>
        </div>
        <div class="md:col-span-3">
            <select id="po-vendor-filter" aria-label="Filter by Vendor"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-sm focus:border-accent focus:outline-none">
                <option value="">All Suppliers / Vendors</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <select id="po-plant-filter" aria-label="Filter by Plant"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-sm focus:border-accent focus:outline-none">
                <option value="">All Delivery Plants</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <select id="po-priority-filter" aria-label="Filter by Priority"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-sm focus:border-accent focus:outline-none">
                <option value="">All Priority Levels</option>
                <option value="URGENT">Critical / Urgent &lt; 24h</option>
                <option value="EXPEDITED">Expedited Schedule</option>
                <option value="NORMAL">Standard Delivery Cycle</option>
            </select>
        </div>
        <div>
            <button id="po-filter-reset"
                class="btn btn-sm btn-primary w-full h-9.5 flex items-center justify-center"
                title="Reset Filters" aria-label="Reset Filters" type="button">
                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
            </button>
        </div>
    </div>
</div>
