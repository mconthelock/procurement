<!-- Section 2: Summary KPI Ribbon (4-Tile Architectural Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
    <!-- KPI 1: Total Active POs -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-primary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Total Active POs</span>
                <span class="material-symbols-outlined text-[20px] text-mute">receipt_long</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold text-primary">
                    <span id="kpi-total-pos" class="font-mono">0</span>
                    <span class="text-xs text-mute font-normal ml-1">Orders</span>
                </div>
                <div id="kpi-total-amount" class="font-mono text-xs text-secondary font-semibold">฿0.00</div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>All Open &amp; Recent POs</span>
            <span class="font-mono text-primary font-semibold">AMEC-EDI</span>
        </div>
    </div>

    <!-- KPI 2: Awaiting Confirmation -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-error">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Awaiting Confirmation</span>
                <span id="kpi-overdue-badge" class="badge badge-xs badge-error font-mono font-bold">0 URGENT</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold text-error">
                    <span id="kpi-awaiting-pos" class="font-mono">0</span>
                    <span class="text-xs text-mute font-normal ml-1">Orders</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>E-Signature Required</span>
            <span id="kpi-awaiting-amount" class="font-mono text-primary font-semibold">฿0.00</span>
        </div>
    </div>

    <!-- KPI 3: In Production Line -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-warning">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">In Production Line</span>
                <span class="material-symbols-outlined text-[20px] text-mute">precision_manufacturing</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold text-warning">
                    <span id="kpi-production-pos" class="font-mono">0</span>
                    <span class="text-xs text-mute font-normal ml-1">Orders</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Active Manufacturing</span>
            <span id="kpi-production-amount" class="font-mono text-primary font-semibold">฿0.00</span>
        </div>
    </div>

    <!-- KPI 4: Ready / In Transit -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-success">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Ready / In Transit</span>
                <span class="badge badge-xs badge-success font-mono font-bold">ASN ISSUED</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold text-success">
                    <span id="kpi-transit-pos" class="font-mono">0</span>
                    <span class="text-xs text-mute font-normal ml-1">Orders</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Dock Schedule Verified</span>
            <span id="kpi-transit-amount" class="font-mono text-primary font-semibold">฿0.00</span>
        </div>
    </div>
</div>
