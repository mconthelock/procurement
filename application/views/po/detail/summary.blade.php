<!-- Section 2: PO Metadata & Delivery KPI Ribbon (4-Tile Architectural Grid) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
    <!-- Tile 1: Total Order Value -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-primary">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Total Order Value</span>
                <span class="material-symbols-outlined text-[20px] text-mute">payments</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div id="kpi-detail-amount" class="text-2xl font-bold font-mono text-primary">฿0.00</div>
                <span id="kpi-detail-currency" class="badge badge-xs badge-outline font-mono font-bold">THB</span>
            </div>
            <p id="kpi-detail-qty-summary" class="mt-1 text-xs text-secondary font-mono truncate">
                0 Line Items
            </p>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Payment Terms</span>
            <span id="kpi-detail-terms" class="font-mono text-primary font-semibold">Net 30 Days</span>
        </div>
    </div>

    <!-- Tile 2: Target Delivery Schedule -->
    <div id="kpi-detail-delivery-card"
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-error">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Target Delivery</span>
                <span class="material-symbols-outlined text-[20px] text-mute">event</span>
            </div>
            <div class="mt-2 flex items-baseline justify-between gap-2">
                <div id="kpi-detail-delivery" class="text-2xl font-bold font-mono text-primary">-</div>
            </div>
            <p id="kpi-detail-leadtime" class="mt-1 text-xs text-secondary truncate">
                Committed Dock Date
            </p>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Incoterms</span>
            <span id="kpi-detail-incoterm" class="font-mono text-primary font-semibold">DDP Amata</span>
        </div>
    </div>

    <!-- Tile 3: Receiving Plant & Dock -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-warning">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">Receiving Plant</span>
                <span class="material-symbols-outlined text-[20px] text-mute">factory</span>
            </div>
            <div class="mt-2">
                <div id="kpi-detail-plant-code" class="text-xl font-bold font-mono text-primary">-</div>
                <p id="kpi-detail-plant-name" class="mt-1 text-xs text-secondary truncate">-</p>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>Assigned Bay</span>
            <span id="kpi-detail-dock" class="font-mono text-primary font-semibold truncate max-w-[160px]">-</span>
        </div>
    </div>

    <!-- Tile 4: ASN & ECN Technical Control -->
    <div
        class="card bg-base-100 p-4 shadow-sm relative flex flex-col justify-between border border-base-300 border-t-4 border-t-success">
        <div>
            <div class="flex items-center justify-between text-mute text-xs">
                <span class="uppercase tracking-wider font-bold">ASN &amp; ECN Control</span>
                <span class="material-symbols-outlined text-[20px] text-mute">qr_code_2</span>
            </div>
            <div class="mt-2">
                <div id="kpi-detail-asn" class="text-xl font-bold font-mono text-info">Not Issued</div>
                <p class="mt-1 text-xs text-secondary font-mono truncate">
                    ECN: <span id="kpi-detail-ecn" class="text-primary font-semibold">-</span>
                </p>
            </div>
        </div>
        <div class="mt-3 pt-2 border-t border-base-200 flex items-center justify-between text-xs text-mute">
            <span>EDI Protocol</span>
            <span class="font-mono text-success font-semibold">v4.2 Verified</span>
        </div>
    </div>
</div>
