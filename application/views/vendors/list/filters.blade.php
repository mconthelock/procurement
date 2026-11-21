<!-- Search, Categorization & Filter Toolbar -->
<div class="bg-white border border-base-300 p-4 flex flex-col gap-3">
    <!-- Search Line -->
    <div class="flex flex-col md:flex-row items-stretch gap-2">
        <div class="relative flex-1">
            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-[18px]">search</span>
            <input
                class="w-full bg-white border border-border-medium rounded-none pl-9 pr-3 py-2 text-body-sm text-gray-700 placeholder:text-gray-400 focus:border-[#005cba] focus:outline-none"
                id="vendorSearchInput"
                placeholder="Search by Vendor Name, Vendor Code (e.g. V-884029-TH, 80018), Tax ID, or Commodity..."
                type="text" />
        </div>
        <button
            class="bg-black hover:bg-neutral-800 text-white px-5 py-2 rounded-none font-body-sm text-sm font-semibold flex items-center justify-center gap-1.5 transition-colors"
            type="button">
            <span class="material-symbols-outlined text-[16px]">filter_alt</span>
            <span>Apply Query</span>
        </button>
        <button
            class="bg-white hover:bg-gray-50 text-gray-700 border border-border-medium px-3.5 py-2 rounded-none font-body-sm text-sm font-medium transition-colors"
            onclick="
									document.getElementById(
										'vendorSearchInput',
									).value = ''
								"
            type="button">
            <span>Reset Filters</span>
        </button>
    </div>
    <!-- Filter Dropdowns Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 pt-2 border-t border-border-light">
        <div class="flex flex-col gap-1">
            <label class="text-[11px] uppercase text-gray-500 tracking-wider">Tier
                Level</label>
            <select
                class="bg-white border border-border-medium rounded-none px-2.5 py-1.5 text-body-sm text-gray-700 text-sm focus:border-[#005cba] focus:outline-none">
                <option>All Tiers (Tier-1 & Tier-2)</option>
                <option>Tier-1 Direct AMEC Partner</option>
                <option>
                    Tier-2 Subcontractor Fabricator
                </option>
                <option>Tier-1 Global Import Hub</option>
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[11px] uppercase text-gray-500 tracking-wider">Commodity
                Category</label>
            <select
                class="bg-white border border-border-medium rounded-none px-2.5 py-1.5 text-body-sm text-gray-700 text-sm focus:border-[#005cba] focus:outline-none">
                <option>All Commodities</option>
                <option>
                    Sheet Metal & Hoistway Structure
                </option>
                <option>
                    Electrical Panels & Control Harness
                </option>
                <option>
                    Traction Machine & Sheave Casting
                </option>
                <option>
                    Fasteners, Binder & Mounting Clips
                </option>
                <option>
                    Elevator Door Mechanism & Sills
                </option>
                <option>
                    Surface Treatment & Powder Coating
                </option>
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[11px] uppercase text-gray-500 tracking-wider">Quality
                Grade</label>
            <select
                class="bg-white border border-border-medium rounded-none px-2.5 py-1.5 text-body-sm text-gray-700 text-sm focus:border-[#005cba] focus:outline-none">
                <option>All Grades</option>
                <option>
                    Grade A Certified (Exemplary)
                </option>
                <option>
                    Grade B Qualified (Compliant)
                </option>
                <option>
                    Grade B+ (In Corrective Remediation)
                </option>
                <option>Grade C / Under Probation</option>
            </select>
        </div>
        <div class="flex flex-col gap-1">
            <label class="text-[11px] uppercase text-gray-500 tracking-wider">Operational
                Location</label>
            <select
                class="bg-white border border-border-medium rounded-none px-2.5 py-1.5 text-body-sm text-gray-700 text-sm focus:border-[#005cba] focus:outline-none">
                <option>All Locations / Estates</option>
                <option>
                    Amata City Chonburi (Zone 1)
                </option>
                <option>
                    WHA Chonburi / Eastern Seaboard
                </option>
                <option>Amata City Rayong</option>
                <option>
                    Samut Prakan / BKK Industrial
                </option>
                <option>
                    Overseas (Japan / Singapore)
                </option>
            </select>
        </div>
    </div>
    <!-- Result Count & Quick Filter Badges -->
    <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-base-300 text-caption">
        <div class="flex items-center gap-2">
            <span class="text-gray-500 uppercase text-[11px]">Active View:</span>
            <span class="font-mono tabular-nums font-semibold text-black">Showing 1 - 8 of 148
                Registered
                Vendors</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-gray-500 text-[11px]">Quick Views:</span>
            <button
                class="bg-white border border-border-medium text-gray-700 px-2 py-0.5 text-[11px] hover:border-[#005cba]"
                type="button">
                Chonburi Plant Direct
            </button>
            <button
                class="bg-white border border-border-medium text-gray-700 px-2 py-0.5 text-[11px] hover:border-[#005cba]"
                type="button">
                Audit Due < 30 Days </button>
                    <button
                        class="bg-white border border-border-medium text-gray-700 px-2 py-0.5 text-[11px] hover:border-[#005cba]"
                        type="button">
                        Top 10 Volume Fabricators
                    </button>
        </div>
    </div>
</div>
