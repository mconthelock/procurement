<!-- Section 2: Summary KPI Ribbon (4-Tile Architectural Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
    <!-- KPI 1: Total Master Items -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-primary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Total Master Items</span>
                <span class="material-symbols-outlined text-[20px] text-mute">inventory_2</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-total-items">0</span>
                    <span class="text-xs text-mute font-sans font-normal ml-1">SKUs</span>
                </div>
                <span id="kpi-active-badge" class="badge badge-xs badge-success font-mono font-bold">0% ACTIVE</span>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Active (IM): <strong id="kpi-active-count" class="text-primary font-mono font-semibold">0</strong></span>
            <span>Inactive (IZ): <strong id="kpi-inactive-count" class="text-error font-mono font-semibold">0</strong></span>
        </div>
    </div>

    <!-- KPI 2: Bulk & JOP Parts -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-info">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Bulk &amp; JOP Mix</span>
                <span class="material-symbols-outlined text-[20px] text-info">category</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-bulk-count">0</span>
                    <span class="text-base-300 font-normal mx-1">/</span>
                    <span id="kpi-jop-count" class="text-info">0</span>
                </div>
                <span class="badge badge-xs badge-outline font-mono">IITYP SPLIT</span>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Stock (A): <strong id="kpi-stock-count" class="font-mono text-primary font-semibold">0</strong></span>
            <span>Subcon (B/C): <strong id="kpi-subcon-count" class="font-mono text-primary font-semibold">0</strong></span>
        </div>
    </div>

    <!-- KPI 3: Low Stock / Below Min Watch -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-warning">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Safety Stock Watch</span>
                <span class="material-symbols-outlined text-[20px] text-warning">warning</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-lowstock-count">0</span>
                    <span class="text-xs text-mute font-sans font-normal ml-1">Below Min</span>
                </div>
                <span class="badge badge-xs badge-warning font-mono font-bold">IMIN ALERT</span>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Page Stock Value</span>
            <strong id="kpi-stock-value" class="font-mono text-primary font-semibold">฿0.00</strong>
        </div>
    </div>

    <!-- KPI 4: Country of Origin Coverage -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-success">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Origin Compliance</span>
                <span class="material-symbols-outlined text-[20px] text-success">verified_user</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold font-mono text-primary">
                    <span id="kpi-origin-pct">0%</span>
                    <span class="text-xs text-mute font-sans font-normal ml-1">Mapped</span>
                </div>
                <span class="badge badge-xs badge-ghost font-mono">COO</span>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Missing Origin</span>
            <strong id="kpi-origin-missing" class="font-mono text-error font-semibold">0</strong>
        </div>
    </div>
</div>
