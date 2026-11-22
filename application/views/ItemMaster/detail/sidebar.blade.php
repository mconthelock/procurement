<!-- Right Lateral Supporting Sidebar (4 cols) -->
<aside class="lg:col-span-4 flex flex-col gap-space-md">
    <!-- Card R1: Engineering Schematic / Drawing Preview Card -->
    <div class="bg-base-100 border border-base-300 shadow-sm overflow-hidden">
        <div class="relative w-full h-44 bg-neutral text-white border-b border-base-300 flex flex-col items-center justify-center p-4">
            <div class="absolute top-2 right-2 bg-primary text-white font-mono text-[10px] px-2 py-0.5 font-bold uppercase tracking-wider border border-secondary">
                BPCS DRAWING REF
            </div>
            <span class="material-symbols-outlined text-[48px] text-base-300/60 mb-1">architecture</span>
            <div id="side-drawing-code" class="font-mono text-sm font-bold text-white tracking-wide text-center break-all">
                -
            </div>
            <div class="text-[11px] font-mono text-base-300 mt-0.5">
                IDRF: <span id="side-idrf">-</span>
            </div>
            <div class="absolute bottom-2 left-2 bg-base-100 text-primary px-2 py-0.5 text-[11px] font-mono font-bold border border-base-300">
                TYPE: <span id="side-iityp">-</span>
            </div>
        </div>
        <div class="p-space-md">
            <div class="text-[11px] font-bold text-mute uppercase tracking-wider">Part Classification Context</div>
            <div id="side-idesc" class="text-sm font-bold text-primary mt-0.5">-</div>
            <div class="mt-3 pt-2.5 border-t border-base-200 grid grid-cols-3 gap-2 text-xs font-mono">
                <div>
                    <div class="text-[10px] text-mute uppercase">Weight</div>
                    <div id="side-iwght" class="font-bold text-primary">-</div>
                </div>
                <div>
                    <div class="text-[10px] text-mute uppercase">L × W</div>
                    <div id="side-dims" class="font-bold text-primary">-</div>
                </div>
                <div>
                    <div class="text-[10px] text-mute uppercase">Pack</div>
                    <div id="side-ipack" class="font-bold text-primary">-</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card R2: Planner & Buyer Authority Card -->
    <div class="bg-base-100 border border-base-300 shadow-sm p-space-md">
        <div class="flex items-center gap-2 pb-2.5 border-b border-base-200 mb-3">
            <span class="material-symbols-outlined text-info text-[20px]">badge</span>
            <span class="text-xs font-bold text-primary uppercase tracking-wider">Planner &amp; Purchasing Authority</span>
        </div>
        <div class="flex items-start gap-3">
            <div id="side-planner-avatar"
                class="w-11 h-11 bg-base-200 border border-base-300 flex items-center justify-center font-bold text-primary font-mono text-sm shrink-0">
                --
            </div>
            <div class="flex-1 min-w-0">
                <div id="side-planner-name" class="text-sm font-bold text-primary truncate">Planner / Buyer</div>
                <div class="text-xs text-mute mt-0.5">
                    Buyer Code (<span class="font-mono">IBUYC</span>): <strong id="side-ibuyc"
                        class="font-mono text-primary">-</strong>
                </div>
                <div class="text-xs text-mute">
                    Purch Code (<span class="font-mono">IPURC</span>): <strong id="side-ipurc"
                        class="font-mono text-primary">-</strong>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-2.5 border-t border-base-200 flex flex-col gap-1.5 font-mono text-xs">
            <div class="flex items-center justify-between gap-2">
                <span class="text-mute">Primary Vendor:</span>
                <a id="side-ivend-link" href="#" class="text-info hover:underline font-bold truncate">-</a>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-mute">Secondary Vendor:</span>
                <span id="side-iven2" class="text-primary font-semibold">-</span>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-mute">Warehouse / Loc:</span>
                <span id="side-wsh-loc" class="text-primary font-semibold">-</span>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-mute">G/L Account:</span>
                <span id="side-iglno" class="text-primary font-semibold">-</span>
            </div>
        </div>
    </div>

    <!-- Card R3: Master Control Flags & Compliance Status -->
    <div class="bg-base-100 border border-base-300 shadow-sm p-space-md">
        <div class="flex items-center justify-between pb-2.5 border-b border-base-200 mb-3">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-success text-[20px]">verified</span>
                <span class="text-xs font-bold text-primary uppercase tracking-wider">ERP Control &amp; Compliance</span>
            </div>
            <span id="side-status-pill" class="badge badge-xs badge-success font-mono font-bold uppercase">IM</span>
        </div>
        <div class="flex flex-col gap-2 text-xs">
            <div class="flex items-center justify-between py-1 border-b border-base-200">
                <span class="text-mute">MRP Control (<span class="font-mono">IMRP</span>)</span>
                <span id="flag-imrp" class="badge badge-xs badge-ghost font-mono font-bold">-</span>
            </div>
            <div class="flex items-center justify-between py-1 border-b border-base-200">
                <span class="text-mute">JIT Scheduling (<span class="font-mono">IJIT</span>)</span>
                <span id="flag-ijit" class="badge badge-xs badge-ghost font-mono font-bold">-</span>
            </div>
            <div class="flex items-center justify-between py-1 border-b border-base-200">
                <span class="text-mute">Inspection Req (<span class="font-mono">IFII</span>)</span>
                <span id="flag-ifii" class="badge badge-xs badge-ghost font-mono font-bold">-</span>
            </div>
            <div class="flex items-center justify-between py-1 border-b border-base-200">
                <span class="text-mute">Shop Order (<span class="font-mono">ISOFL</span>)</span>
                <span id="flag-isofl" class="badge badge-xs badge-ghost font-mono font-bold">-</span>
            </div>
            <div class="flex items-center justify-between py-1 border-b border-base-200">
                <span class="text-mute">Freeze Flag (<span class="font-mono">IFRFG</span>)</span>
                <span id="flag-ifrfg" class="badge badge-xs badge-ghost font-mono font-bold">-</span>
            </div>
            <div class="flex items-center justify-between py-1">
                <span class="text-mute">Country of Origin</span>
                <span id="flag-country" class="badge badge-xs badge-ghost font-mono font-bold">-</span>
            </div>
        </div>
    </div>

    <!-- Card R4: Engineering / Origin Action Box -->
    <div class="bg-base-200 border border-primary p-space-md">
        <div class="flex items-center gap-2 text-primary text-xs uppercase font-bold tracking-wider mb-1">
            <span class="material-symbols-outlined text-[18px]">engineering</span>
            <span>Item Master Maintenance</span>
        </div>
        <p class="text-xs text-mute leading-relaxed mb-3">
            Update Country of Origin, Manufacturer details, or jump directly to the procurement &amp; origin compliance
            tab for this SKU.
        </p>
        <button type="button" id="side-btn-jump-origin" class="btn btn-sm btn-primary w-full gap-1.5">
            <span>Open Origin &amp; Sourcing Tab</span>
            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
        </button>
    </div>
</aside>
