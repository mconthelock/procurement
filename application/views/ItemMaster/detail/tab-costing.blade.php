<!-- TAB 3: Costing, Pricing & BPCS 9-Bucket Cost Matrix -->
<div id="tab-costing" class="item-tab-panel hidden p-space-lg flex-col gap-space-md">
    <!-- Card 3A: Master Unit Cost & Pricing Summary -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-info text-[18px]">payments</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">Unit Cost &amp; Commercial Pricing</span>
            </div>
            <span class="font-mono text-[11px] text-mute">IIM COST HEADER</span>
        </div>
        <div class="p-space-md grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
            <div class="bg-base-200/50 border border-base-300 p-3">
                <div class="text-[10px] font-bold uppercase text-mute">Standard Cost (<span class="font-mono">ISCST</span>)</div>
                <div id="cost-ISCST" class="text-lg font-bold font-mono text-primary mt-1">0.0000</div>
            </div>
            <div class="bg-base-200/50 border border-base-300 p-3">
                <div class="text-[10px] font-bold uppercase text-mute">Actual Cost (<span class="font-mono">IACST</span>)</div>
                <div id="cost-IACST" class="text-lg font-bold font-mono text-info mt-1">0.0000</div>
            </div>
            <div class="bg-base-200/50 border border-base-300 p-3">
                <div class="text-[10px] font-bold uppercase text-mute">Frozen / Future Cost (<span class="font-mono">IFCST</span>)</div>
                <div id="cost-IFCST" class="text-lg font-bold font-mono text-secondary mt-1">0.0000</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">List Price (<span class="font-mono">ILIST</span>)</div>
                <div id="cost-ILIST" class="font-mono font-bold text-primary mt-0.5">0.0000</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Order Cost (<span class="font-mono">IORDC</span>)</div>
                <div id="cost-IORDC" class="font-mono font-bold text-primary mt-0.5">0.0000</div>
            </div>
            <div class="border border-base-200 p-2.5">
                <div class="text-[10px] text-mute uppercase">Vendor Unit List / Price (<span class="font-mono">IVULI / IVULP</span>)</div>
                <div id="cost-VUL" class="font-mono font-bold text-primary mt-0.5">0.00 / 0.00</div>
            </div>
        </div>
    </div>

    <!-- Card 3B: BPCS 9-Bucket Cost Breakdown Matrix -->
    <div class="bg-base-100 border border-base-300">
        <div class="bg-base-200 px-space-md py-2.5 border-b border-base-300 flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[18px]">table_chart</span>
                <span class="text-xs font-bold uppercase tracking-wider text-primary">BPCS 9-Bucket Cost Rollup Matrix (Buckets 1–9)</span>
            </div>
            <label class="flex items-center gap-1.5 text-xs text-mute cursor-pointer">
                <input id="toggle-nonzero-buckets" type="checkbox" class="checkbox checkbox-xs checkbox-primary" />
                <span>Hide zero buckets</span>
            </label>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-xs w-full border-collapse text-left">
                <thead>
                    <tr class="bg-primary text-white text-[11px] uppercase tracking-wider">
                        <th class="py-2.5 px-3">Bucket</th>
                        <th class="py-2.5 px-3 text-right">Std This<br><span class="font-mono font-normal opacity-75">ICST</span></th>
                        <th class="py-2.5 px-3 text-right">Std Prev<br><span class="font-mono font-normal opacity-75">ICSP</span></th>
                        <th class="py-2.5 px-3 text-right">Froz This<br><span class="font-mono font-normal opacity-75">ICFT</span></th>
                        <th class="py-2.5 px-3 text-right">Froz Prev<br><span class="font-mono font-normal opacity-75">ICFP</span></th>
                        <th class="py-2.5 px-3 text-right">Act This<br><span class="font-mono font-normal opacity-75">ICAT</span></th>
                        <th class="py-2.5 px-3 text-right">Act Prev<br><span class="font-mono font-normal opacity-75">ICAP</span></th>
                        <th class="py-2.5 px-3 text-right">Sim This<br><span class="font-mono font-normal opacity-75">ISCT</span></th>
                        <th class="py-2.5 px-3 text-right">Sim Prev<br><span class="font-mono font-normal opacity-75">ISCP</span></th>
                    </tr>
                </thead>
                <tbody id="cost-buckets-tbody" class="divide-y divide-base-200 text-xs font-mono">
                    <tr>
                        <td colspan="9" class="py-4 text-center text-mute">Loading cost buckets...</td>
                    </tr>
                </tbody>
                <tfoot id="cost-buckets-tfoot" class="bg-base-200 font-mono text-xs font-bold border-t border-base-300">
                </tfoot>
            </table>
        </div>
    </div>
</div>
