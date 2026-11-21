<!-- Slide-Over Detail Drawer: Purchase Order Inspection Pane -->
<div class="fixed inset-0 z-[2000] hidden" id="poDetailDrawer" role="dialog" aria-modal="true"
    aria-labelledby="drawer-po-number">
    <div class="absolute inset-0 bg-primary/70 js-close-po-drawer"></div>
    <div
        class="absolute top-0 right-0 bottom-0 w-full max-w-[760px] bg-white shadow-2xl flex flex-col z-10 border-l border-primary overflow-hidden">
        <!-- Drawer Header -->
        <div class="px-space-lg py-space-md bg-primary text-white flex items-center justify-between">
            <div class="flex items-center gap-space-sm">
                <div class="w-2.5 h-6 bg-accent"></div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold font-mono" id="drawer-po-number">-</span>
                        <span class="badge badge-xs badge-primary font-mono font-bold uppercase"
                            id="drawer-po-status">-</span>
                        <span class="badge badge-xs badge-outline border-white/40 text-white font-mono"
                            id="drawer-po-rev">Rev. 00</span>
                    </div>
                    <div class="text-xs text-white/75 mt-0.5" id="drawer-po-subtitle">
                        Purchase Order Specification • Mitsubishi Elevator Asia Co., Ltd. (AMEC)
                    </div>
                </div>
            </div>
            <button class="btn btn-ghost btn-sm btn-square text-white js-close-po-drawer" type="button"
                aria-label="Close drawer">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>

        <!-- Drawer Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-space-lg space-y-space-lg bg-white">
            <!-- Urgent / Pending Acknowledgment Alert (shown dynamically) -->
            <div id="drawer-po-alert"
                class="hidden p-space-md bg-red-50 border-l-4 border-error items-start gap-space-sm">
                <span class="material-symbols-outlined text-error text-[24px] shrink-0 mt-0.5">error</span>
                <div class="text-xs">
                    <div class="text-sm font-bold text-error" id="drawer-alert-title">ACTION REQUIRED</div>
                    <p class="text-primary mt-1 leading-relaxed" id="drawer-alert-text">-</p>
                </div>
            </div>

            <!-- Key PO Metadata Grid -->
            <div
                class="grid grid-cols-2 md:grid-cols-4 gap-space-md p-space-md bg-base-200 border border-base-300 text-xs">
                <div>
                    <span class="uppercase text-mute block font-bold">Issue Date</span>
                    <span class="font-mono font-bold text-primary" id="drawer-po-issued">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Target Delivery</span>
                    <span class="font-mono font-bold text-primary" id="drawer-po-delivery">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Total Amount</span>
                    <span class="font-mono font-bold text-primary" id="drawer-po-amount">-</span>
                </div>
                <div>
                    <span class="uppercase text-mute block font-bold">Priority / Terms</span>
                    <span class="font-mono font-bold text-secondary" id="drawer-po-priority">-</span>
                </div>
            </div>

            <!-- Supplier & Delivery Plant Card -->
            <div class="border border-base-300">
                <div class="bg-base-200 px-space-md py-3 border-b border-base-300 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">
                        Supplier &amp; Receiving Plant Assignment
                    </span>
                    <span class="font-mono text-[11px] text-mute" id="drawer-po-buyer">AMEC BUYER</span>
                </div>
                <div class="p-space-md grid grid-cols-1 sm:grid-cols-2 gap-space-md text-xs bg-white">
                    <div>
                        <span class="uppercase text-mute block font-bold">Supplier / Vendor</span>
                        <span class="font-bold text-primary text-sm block" id="drawer-po-vendor-name">-</span>
                        <span class="font-mono text-mute" id="drawer-po-vendor-code">-</span>
                    </div>
                    <div>
                        <span class="uppercase text-mute block font-bold">Receiving Plant &amp; Dock</span>
                        <span class="font-bold text-primary text-sm block" id="drawer-po-plant">-</span>
                        <span class="text-mute" id="drawer-po-dock">-</span>
                    </div>
                    <div>
                        <span class="uppercase text-mute block font-bold">ASN / Shipment Ref.</span>
                        <span class="font-mono font-semibold text-info" id="drawer-po-asn">-</span>
                    </div>
                    <div>
                        <span class="uppercase text-mute block font-bold">ECN / Drawing Ref.</span>
                        <span class="font-mono text-primary" id="drawer-po-ecn">-</span>
                    </div>
                </div>
            </div>

            <!-- Part Specification & Quantity Breakdown -->
            <div class="border border-base-300">
                <div class="bg-base-200 px-space-md py-3 border-b border-base-300 flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-primary">
                        Line Item Specification (รายการสินค้าในใบสั่งซื้อ)
                    </span>
                    <span class="font-mono text-[11px] text-mute" id="drawer-po-currency">THB</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-xs w-full border-collapse text-left">
                        <thead>
                            <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                                <th>Part No.</th>
                                <th>Description</th>
                                <th class="text-right">Order Qty</th>
                                <th class="text-right">Unit Price</th>
                                <th class="text-right">Line Total</th>
                            </tr>
                        </thead>
                        <tbody id="drawer-po-items" class="divide-y divide-base-200 text-xs"></tbody>
                    </table>
                </div>
            </div>

            <!-- Remarks & Audit Note -->
            <div class="p-space-md bg-base-200 border-l-4 border-primary space-y-1 text-xs">
                <span class="uppercase tracking-wider font-bold text-primary block">
                    Procurement Remarks / Delivery Instructions
                </span>
                <p id="drawer-po-remarks" class="text-mute leading-relaxed">-</p>
            </div>
        </div>

        <!-- Drawer Sticky Footer -->
        <div
            class="px-space-lg py-space-md bg-base-200 border-t border-base-300 flex flex-wrap items-center justify-between gap-space-sm">
            <button id="drawer-btn-pdf"
                class="btn btn-sm btn-outline border-primary bg-white text-primary gap-1.5" type="button">
                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                <span>Download PO PDF</span>
            </button>
            <div class="flex items-center gap-2">
                <button class="btn btn-sm btn-ghost js-close-po-drawer" type="button">Close</button>
                <button id="drawer-btn-ack" class="btn btn-sm btn-accent gap-1.5 font-bold" type="button">
                    <span class="material-symbols-outlined text-[18px]">verified</span>
                    <span>Acknowledge PO</span>
                </button>
            </div>
        </div>
    </div>
</div>
