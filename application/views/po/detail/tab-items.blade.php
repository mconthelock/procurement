<!-- Tab Panel 1: Line Items & Pricing -->
<div id="tab-items" role="tabpanel" class="po-detail-panel p-space-lg space-y-space-md">
    <div class="flex flex-wrap items-center justify-between gap-2">
        <div>
            <h2 class="text-sm font-bold uppercase tracking-wider text-primary">
                Order Line Items &amp; Price Breakdown (รายการสินค้าและราคา)
            </h2>
            <p class="text-xs text-mute mt-0.5">
                Verify part number, ECN drawing revision, ordered quantity, and contracted unit price.
            </p>
        </div>
        <span class="badge badge-xs badge-outline font-mono font-bold uppercase" id="items-currency-badge">
            CURRENCY: THB
        </span>
    </div>

    <div class="border border-base-300 overflow-x-auto" tabindex="0" role="region"
        aria-label="Purchase Order Line Items">
        <table class="table table-sm w-full border-collapse text-left">
            <thead>
                <tr class="bg-primary text-white text-xs uppercase tracking-wider">
                    <th class="w-12 text-center">#</th>
                    <th>Part No. &amp; ECN</th>
                    <th>Description / Specification</th>
                    <th class="text-right">Order Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Line Total</th>
                </tr>
            </thead>
            <tbody id="detail-items-tbody" class="divide-y divide-base-200 text-xs"></tbody>
        </table>
    </div>

    <!-- Financial Totals Box -->
    <div class="flex justify-end">
        <div class="w-full sm:w-96 border border-base-300 bg-base-200 p-space-md space-y-2 text-xs">
            <div class="flex items-center justify-between text-mute">
                <span class="uppercase font-bold">Subtotal (Excl. VAT)</span>
                <span id="summary-subtotal" class="font-mono font-semibold text-primary">฿0.00</span>
            </div>
            <div class="flex items-center justify-between text-mute">
                <span class="uppercase font-bold">VAT (7%)</span>
                <span id="summary-vat" class="font-mono font-semibold text-primary">฿0.00</span>
            </div>
            <div class="pt-2 border-t border-base-300 flex items-center justify-between text-sm">
                <span class="uppercase font-bold text-primary">Grand Total</span>
                <span id="summary-grand-total" class="font-mono font-bold text-primary">฿0.00</span>
            </div>
        </div>
    </div>
</div>
