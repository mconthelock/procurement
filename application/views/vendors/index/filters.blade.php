<!-- Section 3: Navigation Tabs & Precision Filter Strip -->
<div class="bg-base-100 border border-base-300 flex flex-col shadow-sm">
    <!-- Status & Group Navigation Tabs -->
    <div class="flex items-center border-b border-base-200 overflow-x-auto px-space-md pt-2 gap-1" id="vendorStatusTabs">
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-bold text-primary border-b-2 border-primary text-nowrap cursor-pointer"
            data-filter-tab="ALL" type="button">
            <span>All Vendors</span>
            <span class="badge badge-xs badge-primary font-mono" data-count="ALL">0</span>
        </button>
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="ACTIVE" type="button">
            <span>Active Approved</span>
            <span class="badge badge-xs badge-success font-mono" data-count="ACTIVE">0</span>
        </button>
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="INACTIVE" type="button">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-error"></span>
                Inactive / Hold
            </span>
            <span class="badge badge-xs badge-error font-mono font-bold" data-count="INACTIVE">0</span>
        </button>
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="DOMESTIC" type="button">
            <span>Domestic (3,4,5,7)</span>
            <span class="badge badge-xs badge-ghost font-mono" data-count="DOMESTIC">0</span>
        </button>
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="OVERSEA" type="button">
            <span>Overseas (1,2,69)</span>
            <span class="badge badge-xs badge-info font-mono" data-count="OVERSEA">0</span>
        </button>
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="SUBCON" type="button">
            <span>Subcontractor (8)</span>
            <span class="badge badge-xs badge-warning font-mono" data-count="SUBCON">0</span>
        </button>
    </div>

    <!-- Advanced Filter Form Controls -->
    <div class="p-space-md bg-base-100 grid grid-cols-1 md:grid-cols-12 gap-space-sm items-center">
        <div class="md:col-span-4">
            <label
                class="input input-sm border border-base-300 bg-base-100 flex items-center gap-2 focus-within:border-accent h-9.5 w-full">
                <span class="material-symbols-outlined text-[18px] text-mute shrink-0">search</span>
                <input id="vendorSearchInput" type="text"
                    placeholder="Search Code, Vendor Name, Tax ID, Category, Contact, City..."
                    class="grow text-sm text-primary placeholder:text-mute outline-none border-none focus:outline-none" />
            </label>
        </div>
        <div class="md:col-span-3">
            <select id="vendorGroupFilter"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                <option value="">All Vendor Groups (1–8)</option>
                <option value="1">1 — Overseas (MELCO Group)</option>
                <option value="2">2 — Overseas (Non-MELCO)</option>
                <option value="3">3 — Domestic BOI</option>
                <option value="4">4 — Domestic IPO</option>
                <option value="5">5 — Domestic Vendor</option>
                <option value="6">6 — Non-Production (AMEC PO)</option>
                <option value="7">7 — Domestic FTA Privilege</option>
                <option value="8">8 — Sub-Contractor</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <select id="vendorCountryFilter"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                <option value="">All Countries</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <select id="vendorCurrencyFilter"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs font-mono focus:border-accent focus:outline-none">
                <option value="">All Currencies</option>
            </select>
        </div>
        <div class="md:col-span-1">
            <button id="vendorFilterReset" class="btn btn-sm btn-primary w-full h-9.5 flex items-center justify-center"
                title="Reset Filters" type="button">
                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
            </button>
        </div>
    </div>
</div>
