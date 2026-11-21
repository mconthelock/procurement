<!-- Tab 2: Vendor Codes & Payment Terms (Read-Only) -->
<div id="tab-codes" role="tabpanel" class="vendor-detail-panel tab-content hidden! p-space-lg bg-base-100">
    <div class="border border-base-300">
        <div class="px-space-md py-3 bg-base-200 border-b border-base-300 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-4 bg-primary"></span>
                <h2 class="text-xs font-bold uppercase tracking-wider text-primary">
                    Vendor Codes &amp; Settlement Terms (รหัสคู่ค้าและเงื่อนไขการชำระเงิน)
                </h2>
            </div>
            <span class="font-mono text-[11px] text-mute uppercase">ERP / SAP Codes</span>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-sm w-full border-collapse text-left">
                <thead>
                    <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                        <th>Vendor Code</th>
                        <th>Currency</th>
                        <th>Payment Term</th>
                        <th class="text-center w-32">Status</th>
                    </tr>
                </thead>
                <tbody id="view-vendor-code-container" class="divide-y divide-base-200 text-xs">
                    <tr>
                        <td colspan="4" class="py-6 text-center text-mute italic">Loading vendor codes...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
