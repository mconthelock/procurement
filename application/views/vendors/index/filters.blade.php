<!-- Section 3: Navigation Tabs & Precision Filter Strip -->
<div class="bg-base-100 shadow-sm border border-base-300 flex flex-col">
    <!-- Status Navigation Tabs -->
    <div class="flex items-center border-b border-base-200 overflow-x-auto px-space-md pt-2" id="vendorStatusTabs">
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-bold text-primary border-b-2 border-primary text-nowrap cursor-pointer"
            data-status="" type="button">
            <span>All Registered Vendors</span>
            <span class="badge badge-xs badge-primary font-mono" data-count="ALL">8</span>
        </button>
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer"
            data-status="ACTIVE" type="button">
            <span>Active Approved</span>
            <span class="badge badge-xs badge-success font-mono" data-count="ACTIVE">6</span>
        </button>
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer"
            data-status="AUDIT_PENDING" type="button">
            <span class="flex items-center gap-1.5">
                <span class="w-2 h-2 bg-error"></span>
                Audit Pending / Claim
            </span>
            <span class="badge badge-xs badge-error font-mono font-bold" data-count="AUDIT_PENDING">1</span>
        </button>
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer"
            data-status="RECERT_DUE" type="button">
            <span>Re-cert Due &lt; 30d</span>
            <span class="badge badge-xs badge-warning font-mono font-bold" data-count="RECERT_DUE">1</span>
        </button>
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer"
            data-status="TIER-1" type="button">
            <span>Tier-1 Direct</span>
            <span class="badge badge-xs badge-ghost font-mono" data-count="TIER-1">6</span>
        </button>
        <button
            class="vendor-status-tab flex items-center gap-2 px-space-md py-space-sm text-sm font-semibold text-mute border-b-2 border-transparent text-nowrap cursor-pointer"
            data-status="TIER-2" type="button">
            <span>Tier-2 Subcontractor</span>
            <span class="text-mute font-mono text-[11px]" data-count="TIER-2">(2)</span>
        </button>
    </div>

    <!-- Advanced Filter Form Controls -->
    <div class="p-space-md bg-base-100 grid grid-cols-1 md:grid-cols-12 gap-space-sm items-center">
        <div class="md:col-span-4">
            <label
                class="input input-sm border border-base-300 bg-base-100 flex items-center gap-2 focus-within:border-accent h-9.5 w-full">
                <span class="material-symbols-outlined text-[18px] text-mute shrink-0">search</span>
                <input id="vendorSearchInput" type="text"
                    placeholder="Search Vendor Name, Code (V-884029-TH), SAP ID, Commodity..."
                    class="grow text-sm text-primary placeholder:text-mute outline-none border-none focus:outline-none" />
            </label>
        </div>
        <div class="md:col-span-3">
            <select id="vendorTierFilter"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-sm focus:border-accent focus:outline-none">
                <option value="">All Tiers (Tier-1 &amp; Tier-2)</option>
                <option value="TIER-1">Tier-1 Direct AMEC Partner</option>
                <option value="TIER-1-GLOBAL">Tier-1 Global Import Hub</option>
                <option value="TIER-2">Tier-2 Subcontractor Fabricator</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <select id="vendorCommodityFilter"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-sm focus:border-accent focus:outline-none">
                <option value="">All Commodities</option>
                <option value="SHEET_METAL">Sheet Metal &amp; Hoistway</option>
                <option value="ELECTRICAL">Electrical &amp; Harness</option>
                <option value="CASTING">Traction &amp; Casting</option>
                <option value="FASTENERS">Fasteners &amp; Hardware</option>
                <option value="DOOR">Elevator Door Systems</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <select id="vendorGradeFilter"
                class="select select-sm w-full h-9.5 bg-base-100 border border-base-300 text-sm focus:border-accent focus:outline-none">
                <option value="">All Quality Grades</option>
                <option value="GRADE_A">Grade A Certified</option>
                <option value="GRADE_B">Grade B Qualified</option>
                <option value="GRADE_B_REMEDIAL">Grade B+ (Remedial)</option>
            </select>
        </div>
        <div>
            <button id="vendorFilterReset"
                class="btn btn-sm btn-primary w-full h-9.5 flex items-center justify-center"
                title="Reset Filters" type="button">
                <span class="material-symbols-outlined text-[18px]">restart_alt</span>
            </button>
        </div>
    </div>
</div>
