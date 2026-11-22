<!-- TAB 2: Inventory Balances, MTD/YTD Activity & Cycle Count -->
<div id="tab-inventory" class="item-tab-panel hidden p-space-lg flex-col gap-space-md">
    <!-- Card 2A: Stock Position & Allocation Summary -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[18px]">inventory</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Stock Position, Allocations &amp; Thresholds</span>
            </div>
            <span class="font-mono text-[11px] text-mute">IIM STOCK CONTROLS</span>
        </div>
        <div class="p-space-md grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-xs">
            <div class="bg-base-200/50 border border-base-300 p-3">
                <div class="text-[10px] font-bold uppercase text-mute">Opening Balance (<span class="font-mono">IOPB</span>)</div>
                <div id="inv-IOPB" class="text-lg font-bold font-mono text-primary mt-1">0</div>
            </div>
            <div class="bg-base-200/50 border border-base-300 p-3">
                <div class="text-[10px] font-bold uppercase text-mute">On Order (<span class="font-mono">IONOD</span>)</div>
                <div id="inv-IONOD" class="text-lg font-bold font-mono text-info mt-1">0</div>
            </div>
            <div class="bg-base-200/50 border border-base-300 p-3">
                <div class="text-[10px] font-bold uppercase text-mute">Prod Allocated (<span class="font-mono">IPRDA</span>)</div>
                <div id="inv-IPRDA" class="text-lg font-bold font-mono text-warning mt-1">0</div>
            </div>
            <div class="bg-base-200/50 border border-base-300 p-3">
                <div class="text-[10px] font-bold uppercase text-mute">Cust Allocated (<span class="font-mono">ICUSA</span>)</div>
                <div id="inv-ICUSA" class="text-lg font-bold font-mono text-secondary mt-1">0</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Min Balance (<span class="font-mono">IMIN</span>)</div>
                <div id="inv-IMIN" class="font-mono font-bold text-primary mt-0.5">0</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Max Inventory (<span class="font-mono">IMXIN</span>)</div>
                <div id="inv-IMXIN" class="font-mono font-bold text-primary mt-0.5">0</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Min / Max Reorder (<span class="font-mono">IMINR/IMAXR</span>)</div>
                <div id="inv-REORDER" class="font-mono font-bold text-primary mt-0.5">0 / 0</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Target / Unctrl (<span class="font-mono">ITGQY/IUNCN</span>)</div>
                <div id="inv-TARGET" class="font-mono font-bold text-primary mt-0.5">0 / 0</div>
            </div>
        </div>
    </div>

    <!-- Card 2B: MTD vs YTD Movement Ledger Table -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-info text-[18px]">swap_horiz</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Inventory &amp; Sales Movement Ledger (MTD vs YTD)</span>
            </div>
            <span class="font-mono text-[11px] text-mute">PERIOD ACTIVITY</span>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-xs w-full border-collapse text-left">
                <thead>
                    <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                        <th class="py-2.5 px-space-md">Transaction Category</th>
                        <th class="py-2.5 px-space-md">IIM Columns</th>
                        <th class="py-2.5 px-space-md text-right">Month-To-Date (MTD)</th>
                        <th class="py-2.5 px-space-md text-right">Year-To-Date (YTD)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-base-200 text-xs">
                    <tr class="hover:bg-base-200/60 transition-colors">
                        <td class="py-2.5 px-space-md font-bold text-primary">Receipts</td>
                        <td class="py-2.5 px-space-md font-mono text-mute">IRCT / IYRCT</td>
                        <td id="mov-IRCT" class="py-2.5 px-space-md font-mono text-right text-success font-bold">0</td>
                        <td id="mov-IYRCT" class="py-2.5 px-space-md font-mono text-right text-primary font-bold">0</td>
                    </tr>
                    <tr class="hover:bg-base-200/60 transition-colors">
                        <td class="py-2.5 px-space-md font-bold text-primary">Issues</td>
                        <td class="py-2.5 px-space-md font-mono text-mute">IISS / IYISS</td>
                        <td id="mov-IISS" class="py-2.5 px-space-md font-mono text-right text-primary">0</td>
                        <td id="mov-IYISS" class="py-2.5 px-space-md font-mono text-right text-primary font-bold">0</td>
                    </tr>
                    <tr class="hover:bg-base-200/60 transition-colors">
                        <td class="py-2.5 px-space-md font-bold text-primary">Adjustments</td>
                        <td class="py-2.5 px-space-md font-mono text-mute">IADJ / IYADJ</td>
                        <td id="mov-IADJ" class="py-2.5 px-space-md font-mono text-right text-primary">0</td>
                        <td id="mov-IYADJ" class="py-2.5 px-space-md font-mono text-right text-primary">0</td>
                    </tr>
                    <tr class="hover:bg-base-200/60 transition-colors">
                        <td class="py-2.5 px-space-md font-bold text-primary">Usage Quantity</td>
                        <td class="py-2.5 px-space-md font-mono text-mute">IMTDU / IYTDU</td>
                        <td id="mov-IMTDU" class="py-2.5 px-space-md font-mono text-right text-primary">0</td>
                        <td id="mov-IYTDU" class="py-2.5 px-space-md font-mono text-right text-primary font-bold">0</td>
                    </tr>
                    <tr class="hover:bg-base-200/60 transition-colors">
                        <td class="py-2.5 px-space-md font-bold text-primary">Production Output</td>
                        <td class="py-2.5 px-space-md font-mono text-mute">IMTDP / IYTDP</td>
                        <td id="mov-IMTDP" class="py-2.5 px-space-md font-mono text-right text-primary">0</td>
                        <td id="mov-IYTDP" class="py-2.5 px-space-md font-mono text-right text-primary">0</td>
                    </tr>
                    <tr class="hover:bg-base-200/60 transition-colors">
                        <td class="py-2.5 px-space-md font-bold text-primary">Sales Units / Amt</td>
                        <td class="py-2.5 px-space-md font-mono text-mute">IMSLS / IYSLS</td>
                        <td id="mov-IMSLS" class="py-2.5 px-space-md font-mono text-right text-primary">0</td>
                        <td id="mov-IYSLS" class="py-2.5 px-space-md font-mono text-right text-primary">0</td>
                    </tr>
                    <tr class="hover:bg-base-200/60 transition-colors">
                        <td class="py-2.5 px-space-md font-bold text-primary">Cost of Sales</td>
                        <td class="py-2.5 px-space-md font-mono text-mute">IMCOS / IYCOS</td>
                        <td id="mov-IMCOS" class="py-2.5 px-space-md font-mono text-right text-primary">0.00</td>
                        <td id="mov-IYCOS" class="py-2.5 px-space-md font-mono text-right text-primary">0.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card 2C: Cycle Count & Usage Analytics -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary text-[18px]">fact_check</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Cycle Count, Usage &amp; Audit Sequence</span>
            </div>
        </div>
        <div class="p-space-md grid grid-cols-2 sm:grid-cols-3 gap-2.5 text-xs">
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Avg Usage (<span class="font-mono">IAVEU</span>)</div>
                <div id="inv-IAVEU" class="font-mono font-bold text-primary mt-0.5">0</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Annual Usage (<span class="font-mono">IYUSE</span>)</div>
                <div id="inv-IYUSE" class="font-mono font-bold text-primary mt-0.5">0</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Safety Flag (<span class="font-mono">SAFLG</span>)</div>
                <div id="inv-SAFLG" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Cycle Count (<span class="font-mono">ICYC / ICYCF</span>)</div>
                <div id="inv-ICYC" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Seq Nos (<span class="font-mono">INSEQ / ITSEQ</span>)</div>
                <div id="inv-SEQ" class="font-mono font-bold text-primary mt-0.5">-</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Pick Tol % (<span class="font-mono">IPCTK</span>)</div>
                <div id="inv-IPCTK" class="font-mono font-bold text-primary mt-0.5">0</div>
            </div>
        </div>
    </div>
</div>
