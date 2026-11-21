<!-- Section 3: Status Navigation Tabs & Precision Filter Strip -->
<div class="bg-base-100 shadow-sm border border-base-300 flex flex-col">
    <!-- Status Navigation Tabs -->
    <div class="flex items-center border-b border-base-200 overflow-x-auto px-space-md pt-2" id="userStatusTabs">
        <button
            class="user-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-bold text-primary border-b-2 border-primary text-nowrap cursor-pointer"
            data-status="" type="button">
            <span>All Users</span>
            <span class="badge badge-xs badge-primary font-mono" id="tab-count-all">0</span>
        </button>
        <button
            class="user-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-status="ACTIVE" type="button">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-success"></span>
                Active
            </span>
            <span class="badge badge-xs badge-success font-mono font-bold" id="tab-count-active">0</span>
        </button>
        <button
            class="user-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-status="PENDING" type="button">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-warning"></span>
                Pending Activation
            </span>
            <span class="badge badge-xs badge-warning font-mono font-bold" id="tab-count-pending">0</span>
        </button>
        <button
            class="user-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer hover:text-primary transition-colors"
            data-status="INACTIVE" type="button">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-error"></span>
                Locked / Inactive
            </span>
            <span class="badge badge-xs badge-error font-mono font-bold" id="tab-count-inactive">0</span>
        </button>
    </div>

    <!-- Advanced Filter Form Controls -->
    <div class="p-space-md bg-base-100 grid grid-cols-1 md:grid-cols-12 gap-space-sm items-center">
        <div class="md:col-span-5">
            <label
                class="input input-sm border border-base-300 bg-base-100 flex items-center gap-2 focus-within:border-accent h-9.5 w-full">
                <span class="material-symbols-outlined text-[18px] text-mute shrink-0">search</span>
                <input id="user-search" type="text"
                    placeholder="Search Name, Username, Email, Vendor Code..."
                    class="grow text-sm text-primary placeholder:text-mute outline-none border-none focus:outline-none" />
            </label>
        </div>
        <div class="md:col-span-4">
            <select id="user-vendor-filter"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-sm focus:border-accent focus:outline-none">
                <option value="">All Registered Vendors</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <select id="user-role-filter"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-sm focus:border-accent focus:outline-none">
                <option value="">All Portal Roles</option>
                <option value="ADMIN">Vendor Admin</option>
                <option value="SALES">Sales / PO Handler</option>
                <option value="LOGISTICS">Logistics / ASN</option>
                <option value="QA">Quality / Claim</option>
            </select>
        </div>
        <div>
            <button id="user-filter-reset"
                class="btn btn-sm btn-primary w-full h-9.5 flex items-center justify-center"
                title="Reset Filters" type="button">
                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
            </button>
        </div>
    </div>
</div>
