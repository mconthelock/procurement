<!-- Section 2: Summary KPI Ribbon (4-Tile Architectural Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
    <!-- KPI 1: Total Available Vendors -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-primary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Total Available Vendors</span>
                <span class="material-symbols-outlined text-[20px] text-mute">corporate_fare</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-list-total">0</span>
                    <span class="text-xs text-mute font-sans font-normal ml-1">Vendors</span>
                </div>
                <span class="badge badge-xs badge-primary font-mono font-bold">INDIRECT + SUBCON</span>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Scope</span>
            <span class="font-mono text-secondary font-semibold">Group 6 &amp; 8</span>
        </div>
    </div>

    <!-- KPI 2: Indirect Vendors -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-info">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Indirect Vendors</span>
                <span class="material-symbols-outlined text-[20px] text-info">inventory_2</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-list-indirect">0</span>
                    <span class="text-xs text-mute font-sans font-normal ml-1">Non-Production</span>
                </div>
                <span class="badge badge-xs badge-info font-mono font-bold">CODE 6XXXX</span>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Local / Overseas</span>
            <span id="kpi-list-indirect-split" class="font-mono text-primary font-semibold">0 / 0</span>
        </div>
    </div>

    <!-- KPI 3: Subcontractors -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-warning">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Subcontractors</span>
                <span class="material-symbols-outlined text-[20px] text-warning">precision_manufacturing</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-list-subcon">0</span>
                    <span class="text-xs text-mute font-sans font-normal ml-1">Contractors</span>
                </div>
                <span class="badge badge-xs badge-warning font-mono font-bold">CODE 8XXXX</span>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Categories</span>
            <strong id="kpi-list-categories" class="font-mono text-primary font-semibold">0</strong>
        </div>
    </div>

    <!-- KPI 4: Active Approved -->
    <div class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-success">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Active Approved</span>
                <span class="material-symbols-outlined text-[20px] text-success">verified</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-list-active">0</span>
                    <span class="text-xs text-mute font-sans font-normal ml-1">Ready for PR</span>
                </div>
                <span id="kpi-list-active-pct" class="badge badge-xs badge-success font-mono font-bold">0%</span>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Countries</span>
            <strong id="kpi-list-countries" class="font-mono text-primary font-semibold">0</strong>
        </div>
    </div>
</div>
