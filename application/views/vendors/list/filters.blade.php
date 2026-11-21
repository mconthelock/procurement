<!-- Section 3: Group Tabs & Precision Filter Strip (Indirect & Subcontractor Only) -->
<div class="bg-base-100 border border-base-300 flex flex-col shadow-sm">
    <!-- Group Navigation Tabs -->
    <div class="flex items-center border-b border-base-200 overflow-x-auto px-space-md pt-2 gap-1" id="vendorListTabs">
        <button
            class="vendor-list-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-bold text-primary border-b-2 border-primary text-nowrap cursor-pointer"
            data-filter-tab="ALL" type="button">
            <span>All Vendors</span>
            <span class="badge badge-xs badge-primary font-mono" data-count="ALL">0</span>
        </button>
        <button
            class="vendor-list-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="INDIRECT" type="button">
            <span>Indirect</span>
            <span class="badge badge-xs badge-info font-mono" data-count="INDIRECT">0</span>
        </button>
        <button
            class="vendor-list-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="SUBCON" type="button">
            <span>Subcontractor</span>
            <span class="badge badge-xs badge-warning font-mono" data-count="SUBCON">0</span>
        </button>
        <button
            class="vendor-list-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-filter-tab="ACTIVE" type="button">
            <span>Active Only</span>
            <span class="badge badge-xs badge-success font-mono" data-count="ACTIVE">0</span>
        </button>
    </div>

    <!-- Filter Form Controls -->
    <div class="p-space-md bg-base-100 grid grid-cols-1 md:grid-cols-12 gap-space-sm items-center">
        <div class="md:col-span-5">
            <label
                class="input input-sm border border-base-300 bg-base-100 flex items-center gap-2 focus-within:border-accent h-9.5 w-full">
                <span class="material-symbols-outlined text-[18px] text-mute shrink-0">search</span>
                <input id="listSearchInput" type="text"
                    placeholder="Search Vendor Code, Name, Category, Contact Person, City..."
                    class="grow text-sm text-primary placeholder:text-mute outline-none border-none focus:outline-none" />
            </label>
        </div>
        <div class="md:col-span-3">
            <select id="listCategoryFilter"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                <option value="">All Categories</option>
            </select>
        </div>
        <div class="md:col-span-3">
            <select id="listCountryFilter"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-xs focus:border-accent focus:outline-none">
                <option value="">All Countries</option>
            </select>
        </div>
        <div class="md:col-span-1">
            <button id="listFilterReset" class="btn btn-sm btn-primary w-full h-9.5 flex items-center justify-center"
                title="Reset Filters" type="button">
                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
            </button>
        </div>
    </div>
</div>
