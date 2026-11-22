<!-- TAB 4: Planning, MRP & Lead Time Controls -->
<div id="tab-planning" class="item-tab-panel hidden p-space-lg flex-col gap-space-md">
    <!-- Card 4A: MRP & Order Policy Parameters -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-warning text-[18px]">settings_suggest</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">MRP &amp; Order Policy Parameters</span>
            </div>
            <span class="font-mono text-[11px] text-mute">BPCS MRP ENGINE</span>
        </div>
        <div class="p-space-md grid grid-cols-1 md:grid-cols-2 gap-x-space-lg">
            <table class="w-full text-xs">
                <tbody class="divide-y divide-base-200">
                    <tr>
                        <td class="py-2 text-mute w-1/2">MRP Control Flag (<span class="font-mono">IMRP</span>)</td>
                        <td id="plan-IMRP" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Order Policy Code (<span class="font-mono">IORDP</span>)</td>
                        <td id="plan-IORDP" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Action Code (<span class="font-mono">IACT</span>)</td>
                        <td id="plan-IACT" class="py-2 font-mono text-primary text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Standard Lot Size (<span class="font-mono">ILOTS</span>)</td>
                        <td id="plan-ILOTS" class="py-2 font-mono text-primary font-bold text-right">0</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Standard Batch Size (<span class="font-mono">IBTCH</span>)</td>
                        <td id="plan-IBTCH" class="py-2 font-mono text-primary font-bold text-right">0</td>
                    </tr>
                </tbody>
            </table>
            <table class="w-full text-xs">
                <tbody class="divide-y divide-base-200">
                    <tr>
                        <td class="py-2 text-mute w-1/2">Incremental Order Qty (<span class="font-mono">IIOQ</span>)</td>
                        <td id="plan-IIOQ" class="py-2 font-mono text-primary text-right">0</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Low-Level Code (<span class="font-mono">ILEVL</span>)</td>
                        <td id="plan-ILEVL" class="py-2 font-mono text-primary font-bold text-right">0</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Low-Level Cost Code (<span class="font-mono">ILCC</span>)</td>
                        <td id="plan-ILCC" class="py-2 font-mono text-primary text-right">0</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">JIT Flag (<span class="font-mono">IJIT</span>)</td>
                        <td id="plan-IJIT" class="py-2 font-mono text-primary font-bold text-right">-</td>
                    </tr>
                    <tr>
                        <td class="py-2 text-mute">Max Order Period / Qty (<span class="font-mono">IMAXP</span>)</td>
                        <td id="plan-IMAXP" class="py-2 font-mono text-primary text-right">0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card 4B: Lead Times, Time Fences & Horizons -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-info text-[18px]">schedule</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Lead Time, Time Fences &amp; Scheduling Horizons</span>
            </div>
            <span class="font-mono text-[11px] text-mute">DAYS / RATES</span>
        </div>
        <div class="p-space-md grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-xs">
            <div class="bg-base-200/50 border border-base-300 p-3">
                <div class="text-[10px] font-bold uppercase text-mute">Total Lead Time (<span class="font-mono">ILEAD</span>)</div>
                <div id="plan-ILEAD" class="text-lg font-bold font-mono text-primary mt-1">0 Days</div>
            </div>
            <div class="bg-base-200/50 border border-base-300 p-3">
                <div class="text-[10px] font-bold uppercase text-mute">Fixed Time Fence (<span class="font-mono">ITFDY</span>)</div>
                <div id="plan-ITFDY" class="text-lg font-bold font-mono text-primary mt-1">0 Days</div>
            </div>
            <div class="bg-base-200/50 border border-base-300 p-3">
                <div class="text-[10px] font-bold uppercase text-mute">Period Order Days (<span class="font-mono">IPODY</span>)</div>
                <div id="plan-IPODY" class="text-lg font-bold font-mono text-primary mt-1">0 Days</div>
            </div>
            <div class="bg-base-200/50 border border-base-300 p-3">
                <div class="text-[10px] font-bold uppercase text-mute">Demand Time Fence (<span class="font-mono">IDMTF</span>)</div>
                <div id="plan-IDMTF" class="text-lg font-bold font-mono text-primary mt-1">0 Days</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Daily LT Rate (<span class="font-mono">IDLTR</span>)</div>
                <div id="plan-IDLTR" class="font-mono font-bold text-primary mt-0.5">0</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Horizon Days (<span class="font-mono">IMBHD</span>)</div>
                <div id="plan-IMBHD" class="font-mono font-bold text-primary mt-0.5">0</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Batch / Buffer Days (<span class="font-mono">IMBDY</span>)</div>
                <div id="plan-IMBDY" class="font-mono font-bold text-primary mt-0.5">0</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Queue Days (<span class="font-mono">IMQDY</span>)</div>
                <div id="plan-IMQDY" class="font-mono font-bold text-primary mt-0.5">0</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Periods (<span class="font-mono">IPERS</span>)</div>
                <div id="plan-IPERS" class="font-mono font-bold text-primary mt-0.5">0</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Arrival Rate (<span class="font-mono">IARRT</span>)</div>
                <div id="plan-IARRT" class="font-mono font-bold text-primary mt-0.5">0</div>
            </div>
            <div class="border border-base-200 p-2.5 col-span-2">
                <div class="text-[10px] text-mute uppercase">Demand Codes (<span class="font-mono">IDMC1 / IDMC2</span>)</div>
                <div id="plan-IDMC" class="font-mono font-bold text-primary mt-0.5">- / -</div>
            </div>
        </div>
    </div>
</div>
