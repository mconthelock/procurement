<!-- Corporate Action Modal: Bulk PO Acknowledgment -->
<div class="fixed inset-0 z-[2100] hidden items-center justify-center p-4" id="bulkAckModal" role="dialog"
    aria-modal="true" aria-labelledby="bulk-ack-modal-title">
    <div class="absolute inset-0 bg-primary/70 js-close-bulk-modal"></div>
    <div
        class="card relative bg-white w-full max-w-lg shadow-2xl border border-base-300 border-t-4 border-t-accent">
        <form id="bulkAckForm" class="card-body p-6 space-y-4 gap-0">
            <div class="flex items-center justify-between border-b border-base-300 pb-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-accent text-[20px]">verified</span>
                    <h2 id="bulk-ack-modal-title" class="text-base text-primary font-bold uppercase tracking-wide">
                        Bulk PO Electronic Acknowledgment
                    </h2>
                </div>
                <button class="btn btn-ghost btn-xs btn-square text-mute js-close-bulk-modal" type="button"
                    aria-label="Close modal">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            <p class="text-xs text-mute leading-relaxed">
                ยืนยันการรับใบสั่งซื้อแบบกลุ่ม • Confirm receipt, unit pricing, ECN drawing revision, and committed
                delivery schedule for the selected Purchase Orders.
            </p>

            <div class="p-space-sm bg-base-200 border border-base-300 text-xs space-y-1.5">
                <div class="flex items-center justify-between">
                    <span class="uppercase font-bold text-primary">Selected Orders</span>
                    <span id="bulk-ack-count" class="badge badge-xs badge-primary font-mono font-bold">0 POs</span>
                </div>
                <div id="bulk-ack-list" class="flex flex-wrap gap-1 font-mono text-[11px]"></div>
            </div>

            <div class="space-y-3">
                <fieldset class="fieldset p-0 gap-1">
                    <label for="bulk-ack-ref" class="label p-0 text-xs uppercase font-bold text-primary">
                        Supplier Confirmation Ref. / Dock Batch
                    </label>
                    <input id="bulk-ack-ref" type="text" placeholder="e.g. ACK-2026-0412"
                        class="input input-sm w-full bg-base-200 border border-base-300 font-mono text-xs focus:border-accent focus:outline-none" />
                </fieldset>
                <fieldset class="fieldset p-0 gap-1">
                    <label for="bulk-ack-remark" class="label p-0 text-xs uppercase font-bold text-primary">
                        Production / Delivery Remarks (Optional)
                    </label>
                    <textarea id="bulk-ack-remark" rows="3"
                        placeholder="Confirm lead time, packaging readiness, or special transport instructions..."
                        class="textarea textarea-sm w-full bg-base-200 border border-base-300 text-xs focus:border-accent focus:outline-none"></textarea>
                </fieldset>
            </div>

            <div class="pt-3 flex justify-end gap-2 border-t border-base-300">
                <button class="btn btn-sm btn-outline border-primary bg-white text-primary js-close-bulk-modal"
                    type="button">
                    Cancel
                </button>
                <button type="submit" class="btn btn-sm btn-accent font-bold gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">verified</span>
                    <span>Confirm &amp; E-Sign</span>
                </button>
            </div>
        </form>
    </div>
</div>
