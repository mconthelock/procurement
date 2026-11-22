<!-- Section 2: Item Master Metadata & Inventory KPI Ribbon (4-Tile Architectural Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
    <!-- Tile 1: Inventory Balance -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-primary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">On-Hand / Opening Bal</span>
                <span class="material-symbols-outlined text-[20px] text-mute">inventory_2</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div id="kpi-detail-onhand" class="text-2xl font-bold font-mono text-primary">0</div>
                <span id="kpi-detail-iums" class="badge badge-xs badge-outline font-mono font-bold">EA</span>
            </div>
            <p class="mt-1 text-xs text-secondary font-mono truncate">
                On-Order (IONOD): <strong id="kpi-detail-ionod" class="text-primary">0</strong>
            </p>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Min Balance (IMIN)</span>
            <span id="kpi-detail-imin" class="font-mono text-primary font-semibold">0</span>
        </div>
    </div>

    <!-- Tile 2: Standard & Actual Cost -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-info">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Standard Cost (ISCST)</span>
                <span class="material-symbols-outlined text-[20px] text-info">payments</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div id="kpi-detail-iscst" class="text-2xl font-bold font-mono text-primary">0.0000</div>
                <span class="badge badge-xs badge-ghost font-mono font-bold">STD</span>
            </div>
            <p class="mt-1 text-xs text-secondary font-mono truncate">
                Actual (IACST): <strong id="kpi-detail-iacst" class="text-primary">0.0000</strong>
            </p>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>List Price (ILIST)</span>
            <span id="kpi-detail-ilist" class="font-mono text-primary font-semibold">0.00</span>
        </div>
    </div>

    <!-- Tile 3: Lead Time & Order Policy -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-warning">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Lead Time (ILEAD)</span>
                <span class="material-symbols-outlined text-[20px] text-warning">schedule</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-detail-ilead">0</span>
                    <span class="text-xs text-mute font-sans font-normal ml-1">Days</span>
                </div>
                <span id="kpi-detail-iordp" class="badge badge-xs badge-warning font-mono font-bold">POL: -</span>
            </div>
            <p class="mt-1 text-xs text-secondary font-mono truncate">
                Lot Size (ILOTS): <strong id="kpi-detail-ilots" class="text-primary">0</strong>
            </p>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>MRP Flag (IMRP)</span>
            <span id="kpi-detail-imrp" class="font-mono text-primary font-semibold">-</span>
        </div>
    </div>

    <!-- Tile 4: Primary Vendor & Planner -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-success">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Primary Vendor (IVEND)</span>
                <span class="material-symbols-outlined text-[20px] text-success">corporate_fare</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div id="kpi-detail-ivend" class="text-xl font-bold font-mono text-primary truncate">-</div>
                <span id="kpi-detail-ibuyc" class="badge badge-xs badge-outline font-mono font-bold">BUY: -</span>
            </div>
            <p class="mt-1 text-xs text-secondary font-mono truncate">
                2nd Vendor (IVEN2): <strong id="kpi-detail-iven2" class="text-primary">-</strong>
            </p>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Origin (COO)</span>
            <span id="kpi-detail-country" class="font-mono text-success font-semibold truncate max-w-[140px]">-</span>
        </div>
    </div>
</div>
