<!-- Section 3: Filtered Query Summary KPI Ribbon -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
    <!-- KPI 1: Matched POs -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-primary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Matched Orders</span>
                <span class="material-symbols-outlined text-[20px] text-mute">receipt_long</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold text-primary">
                    <span id="rpt-kpi-pos" class="font-mono">00</span>
                    <span class="text-xs text-mute font-normal ml-1">POs</span>
                </div>
                <div id="rpt-kpi-lines" class="font-mono text-xs text-secondary font-semibold">0 Lines</div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Unique Suppliers</span>
            <span id="rpt-kpi-vendors" class="font-mono text-primary font-semibold">0 Vendors</span>
        </div>
    </div>

    <!-- KPI 2: Matched Order Value -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-info">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Matched Value (Excl. VAT)</span>
                <span class="material-symbols-outlined text-[20px] text-mute">payments</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div id="rpt-kpi-amount" class="text-2xl font-bold font-mono text-primary">฿0.00M</div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Exact Total</span>
            <span id="rpt-kpi-amount-exact" class="font-mono text-primary font-semibold">฿0.00</span>
        </div>
    </div>

    <!-- KPI 3: Pending Confirmation -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-error">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Pending Confirmation</span>
                <span id="rpt-kpi-urgent" class="badge badge-xs badge-error font-mono font-bold">0 URGENT</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold text-error">
                    <span id="rpt-kpi-awaiting" class="font-mono">00</span>
                    <span class="text-xs text-mute font-normal ml-1">POs</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>72h SLA Watchlist</span>
            <span id="rpt-kpi-awaiting-amount" class="font-mono text-primary font-semibold">฿0 THB</span>
        </div>
    </div>

    <!-- KPI 4: Shipped / ASN Ready -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-success">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Ready / Transit / Done</span>
                <span class="badge badge-xs badge-success font-mono font-bold">FULFILLMENT</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div class="text-2xl font-bold text-success">
                    <span id="rpt-kpi-fulfilled" class="font-mono">00</span>
                    <span class="text-xs text-mute font-normal ml-1">POs</span>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Fulfillment Rate</span>
            <span id="rpt-kpi-rate" class="font-mono text-success font-semibold">0%</span>
        </div>
    </div>
</div>
